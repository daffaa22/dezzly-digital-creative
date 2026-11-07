<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class NegotiationChatTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test visitor can start a negotiation chat session.
     */
    public function test_visitor_can_start_chat_session(): void
    {
        $package = Package::first();

        $response = $this->postJson(route('chat.start'), [
            'customer_name' => 'Dimas Prakoso',
            'customer_whatsapp' => '081234567890',
            'package_id' => $package->id,
            'initial_message' => 'Halo min, saya ingin negosiasi harga untuk acara konser musik kampus.',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'session_token',
            'session_code',
            'session' => ['id', 'customer_name', 'package_name', 'status'],
            'messages',
        ]);

        $token = $response->json('session_token');
        $this->assertDatabaseHas('chat_sessions', [
            'session_token' => $token,
            'customer_name' => 'Dimas Prakoso',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'sender_type' => 'customer',
            'sender_name' => 'Dimas Prakoso',
        ]);
    }

    /**
     * Test visitor can fetch history and send messages.
     */
    public function test_visitor_can_send_and_poll_messages(): void
    {
        $session = ChatSession::createNewSession([
            'customer_name' => 'Sarah Wijaya',
            'customer_whatsapp' => '08987654321',
        ]);

        // Visitor send message
        $sendResponse = $this->postJson(route('chat.send', $session->session_token), [
            'message' => 'Bisa diskon 10% jika tanpa pilot drone?',
        ]);

        $sendResponse->assertStatus(200);
        $this->assertDatabaseHas('chat_messages', [
            'chat_session_id' => $session->id,
            'message' => 'Bisa diskon 10% jika tanpa pilot drone?',
        ]);

        // Visitor polls messages
        $pollResponse = $this->getJson(route('chat.poll', $session->session_token));
        $pollResponse->assertStatus(200);
        $pollResponse->assertJsonFragment([
            'message' => 'Bisa diskon 10% jika tanpa pilot drone?',
        ]);
    }

    /**
     * Test admin can view chats and reply to customer.
     */
    public function test_admin_can_view_and_reply_in_chat(): void
    {
        $admin = User::first();
        $session = ChatSession::createNewSession([
            'customer_name' => 'Budi Santoso',
            'customer_whatsapp' => '0811223344',
        ]);

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'customer',
            'sender_name' => 'Budi Santoso',
            'message' => 'Halo tim Dezzly, apakah tanggal 15 siap?',
        ]);

        // Unauthenticated admin redirected
        $guestResponse = $this->get(route('admin.chats.index'));
        $guestResponse->assertRedirect('/login');

        // Authenticated admin view
        $authResponse = $this->actingAs($admin)->get(route('admin.chats.index'));
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Ruang Negosiasi');

        // Admin send message
        $replyResponse = $this->actingAs($admin)->postJson(route('admin.chats.send', $session), [
            'message' => 'Halo Mas Budi! Tanggal 15 kru kami ready full team.',
        ]);

        $replyResponse->assertStatus(200);
        $this->assertDatabaseHas('chat_messages', [
            'chat_session_id' => $session->id,
            'sender_type' => 'admin',
            'message' => 'Halo Mas Budi! Tanggal 15 kru kami ready full team.',
        ]);
    }

    /**
     * Test admin can mark deal and generate official WhatsApp link.
     */
    public function test_admin_can_mark_deal_and_generate_whatsapp_link(): void
    {
        $admin = User::first();
        $session = ChatSession::createNewSession([
            'customer_name' => 'Fajar Alamsyah',
            'customer_whatsapp' => '0855667788',
        ]);

        $dealResponse = $this->actingAs($admin)->postJson(route('admin.chats.deal', $session), [
            'agreed_price' => 4500000,
            'package_name' => 'Paket Lengkap VIP',
            'event_date' => now()->addDays(20)->format('Y-m-d'),
            'venue_location' => 'Grand Ballroom Mulia',
            'deal_notes' => 'Disepakati kru 2 FG + 2 VG + drone 4K free highlight 1 menit',
        ]);

        $dealResponse->assertStatus(200);
        $dealResponse->assertJsonStructure([
            'status',
            'whatsapp_url',
            'session' => ['id', 'status', 'is_deal', 'agreed_price_formatted'],
        ]);

        $session->refresh();
        $this->assertEquals('deal', $session->status);
        $this->assertNotNull($session->deal_at);
        $this->assertEquals(4500000, $session->agreed_price);

        // System deal card created
        $this->assertDatabaseHas('chat_messages', [
            'chat_session_id' => $session->id,
            'sender_type' => 'system',
            'is_deal_card' => true,
        ]);

        // WhatsApp deal URL contains deal code and agreed price
        $waUrl = $session->getWhatsAppDealUrl();
        $this->assertStringContainsString($session->session_code, $waUrl);
        $this->assertStringContainsString('4.500.000', $waUrl);
    }

    /**
     * Test retention policy: deals older than 60 days are pruned, while recent deals and active chats are kept.
     */
    public function test_prune_command_deletes_deals_older_than_60_days_only(): void
    {
        // 1. Expired deal (> 60 days) -> Should be deleted
        $expiredDeal = ChatSession::createNewSession([
            'customer_name' => 'Klien Lama Deal',
            'customer_whatsapp' => '081111111',
            'status' => 'deal',
            'deal_at' => now()->subDays(62),
            'agreed_price' => 2000000,
        ]);
        ChatMessage::create([
            'chat_session_id' => $expiredDeal->id,
            'sender_type' => 'customer',
            'sender_name' => 'Klien Lama Deal',
            'message' => 'Pesan sesi lama',
        ]);

        // 2. Recent deal (e.g. 10 days ago) -> Must NOT be deleted
        $recentDeal = ChatSession::createNewSession([
            'customer_name' => 'Klien Baru Deal',
            'customer_whatsapp' => '082222222',
            'status' => 'deal',
            'deal_at' => now()->subDays(10),
            'agreed_price' => 3000000,
        ]);

        // 3. Active negotiation (not yet deal, even if started long ago) -> Must NOT be deleted
        $activeOld = ChatSession::createNewSession([
            'customer_name' => 'Klien Belum Deal',
            'customer_whatsapp' => '083333333',
            'status' => 'active',
            'deal_at' => null,
        ]);

        // Run retention prune command
        Artisan::call('chat:prune-old', ['--days' => 60]);

        // Assertions
        $this->assertDatabaseMissing('chat_sessions', ['id' => $expiredDeal->id]);
        $this->assertDatabaseMissing('chat_messages', ['chat_session_id' => $expiredDeal->id]);

        $this->assertDatabaseHas('chat_sessions', ['id' => $recentDeal->id]);
        $this->assertDatabaseHas('chat_sessions', ['id' => $activeOld->id]);
    }
}
