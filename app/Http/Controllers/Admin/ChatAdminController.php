<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ChatAdminController extends Controller
{
    /**
     * Display the admin chat console view.
     */
    public function index(): View
    {
        $totalSessions = ChatSession::count();
        $activeSessions = ChatSession::where('status', 'active')->count();
        $dealSessions = ChatSession::where('status', 'deal')->count();
        $totalUnread = ChatSession::sum('admin_unread_count');

        return view('admin.chats.index', compact(
            'totalSessions',
            'activeSessions',
            'dealSessions',
            'totalUnread'
        ));
    }

    /**
     * Live JSON list of chat sessions for admin sidebar.
     */
    public function getSessions(Request $request): JsonResponse
    {
        $status = $request->query('status', 'all');
        $search = $request->query('q');

        $query = ChatSession::query();

        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'deal') {
            $query->where('status', 'deal');
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('session_code', 'like', "%{$search}%")
                    ->orWhere('customer_whatsapp', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%");
            });
        }

        $sessions = $query->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->take(50)
            ->get()
            ->map(function (ChatSession $s) {
                return [
                    'id' => $s->id,
                    'session_code' => $s->session_code,
                    'customer_name' => $s->customer_name,
                    'customer_whatsapp' => $s->customer_whatsapp,
                    'package_name' => $s->package_name,
                    'status' => $s->status,
                    'is_deal' => $s->isDeal(),
                    'agreed_price' => $s->agreed_price,
                    'agreed_price_formatted' => $s->formattedAgreedPrice(),
                    'admin_unread_count' => $s->admin_unread_count,
                    'last_message_at' => $s->last_message_at?->diffForHumans(),
                    'days_until_prune' => $s->daysUntilPrune(),
                    'deal_at' => $s->deal_at?->format('d/m/Y H:i'),
                ];
            });

        return response()->json([
            'status' => 'success',
            'sessions' => $sessions,
        ]);
    }

    /**
     * Retrieve messages for a specific session and mark customer messages as read.
     */
    public function getMessages(Request $request, ChatSession $session): JsonResponse
    {
        $lastId = (int) $request->query('last_id', 0);

        $query = ChatMessage::where('chat_session_id', $session->id);
        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->orderBy('id', 'asc')->get();

        // Mark customer messages as read by admin
        if ($messages->isNotEmpty() || $lastId === 0) {
            ChatMessage::where('chat_session_id', $session->id)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $session->update(['admin_unread_count' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'session' => [
                'id' => $session->id,
                'session_code' => $session->session_code,
                'customer_name' => $session->customer_name,
                'customer_whatsapp' => $session->customer_whatsapp,
                'package_name' => $session->package_name,
                'status' => $session->status,
                'is_deal' => $session->isDeal(),
                'agreed_price' => $session->agreed_price,
                'agreed_price_formatted' => $session->formattedAgreedPrice(),
                'event_date' => $session->event_date?->format('Y-m-d'),
                'venue_location' => $session->venue_location,
                'deal_notes' => $session->deal_notes,
                'whatsapp_deal_url' => $session->isDeal() ? $session->getWhatsAppDealUrl() : null,
                'days_until_prune' => $session->daysUntilPrune(),
                'deal_at' => $session->deal_at?->format('d/m/Y H:i'),
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Admin sends a message into the chat session.
     */
    public function sendMessage(Request $request, ChatSession $session): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2500'],
        ]);

        $adminName = Auth::user()->name ?? 'Produser Studio';

        $msg = ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'admin',
            'sender_name' => $adminName,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $session->increment('customer_unread_count');
        $session->update(['last_message_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => $msg,
        ]);
    }

    /**
     * Mark a chat session as Deal with agreed terms, and post deal card.
     */
    public function markDeal(Request $request, ChatSession $session): JsonResponse
    {
        $validated = $request->validate([
            'agreed_price' => ['required', 'numeric', 'min:0'],
            'package_name' => ['nullable', 'string', 'max:150'],
            'event_date' => ['nullable', 'date'],
            'venue_location' => ['nullable', 'string', 'max:200'],
            'deal_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $session->update([
            'status' => 'deal',
            'deal_at' => now(),
            'agreed_price' => $validated['agreed_price'],
            'package_name' => $validated['package_name'] ?: $session->package_name,
            'event_date' => $validated['event_date'] ?? null,
            'venue_location' => $validated['venue_location'] ?? null,
            'deal_notes' => $validated['deal_notes'] ?? null,
            'last_message_at' => now(),
        ]);

        $priceFormatted = $session->formattedAgreedPrice() ?? 'Rp 0';
        $dateFormatted = $session->event_date ? $session->event_date->format('d/m/Y') : 'Menyesuaikan';

        // Post System Deal Card Message
        $dealPayload = [
            'agreed_price' => $session->agreed_price,
            'agreed_price_formatted' => $priceFormatted,
            'package_name' => $session->package_name ?: 'Paket Dokumentasi Kustom',
            'event_date' => $dateFormatted,
            'venue_location' => $session->venue_location ?: 'Menyesuaikan Diskusi',
            'deal_notes' => $session->deal_notes,
            'whatsapp_url' => $session->getWhatsAppDealUrl(),
            'deal_at' => now()->format('d/m/Y H:i'),
        ];

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'system',
            'sender_name' => 'Dezzly Deal Concierge',
            'message' => "🎉 KESEPAKATAN DEAL TERCAPAI!\nPaket: {$dealPayload['package_name']}\nHarga Kesepakatan: {$priceFormatted}\nTanggal: {$dateFormatted}\n\nSilakan klik tombol di bawah untuk membuka WhatsApp resmi studio dan menyelesaikan penguncian jadwal acara.",
            'is_deal_card' => true,
            'deal_payload' => $dealPayload,
            'is_read' => false,
        ]);

        $session->increment('customer_unread_count');

        return response()->json([
            'status' => 'success',
            'whatsapp_url' => $session->getWhatsAppDealUrl(),
            'session' => [
                'id' => $session->id,
                'status' => 'deal',
                'is_deal' => true,
                'agreed_price_formatted' => $priceFormatted,
                'deal_at' => $session->deal_at->format('d/m/Y H:i'),
                'days_until_prune' => 60,
                'whatsapp_deal_url' => $session->getWhatsAppDealUrl(),
            ],
        ]);
    }

    /**
     * Delete a chat session manually.
     */
    public function destroy(ChatSession $session): RedirectResponse|JsonResponse
    {
        $code = $session->session_code;
        $session->delete();

        if (request()->wantsJson()) {
            return response()->json(['status' => 'success', 'deleted_code' => $code]);
        }

        return redirect()->route('admin.chats.index')
            ->with('success', "Sesi obrolan [{$code}] berhasil dihapus.");
    }

    /**
     * Manually trigger the 60-day prune cleanup.
     */
    public function pruneExpired(): RedirectResponse
    {
        Artisan::call('chat:prune-old', ['--days' => 60]);
        $output = Artisan::output();

        return redirect()->route('admin.chats.index')
            ->with('success', 'Pembersihan otomatis sesi chat deal lewat 60 hari selesai dieksekusi: '.trim($output));
    }
}
