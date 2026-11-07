<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Start a new chat session from visitor side.
     */
    public function startSession(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_whatsapp' => ['nullable', 'string', 'max:50'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'initial_message' => ['required', 'string', 'max:1500'],
        ]);

        $packageName = null;
        if (! empty($validated['package_id'])) {
            $pkg = Package::find($validated['package_id']);
            $packageName = $pkg ? $pkg->name : null;
        }

        $session = ChatSession::createNewSession([
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'] ?? null,
            'package_id' => $validated['package_id'] ?? null,
            'package_name' => $packageName,
            'initial_notes' => $validated['initial_message'],
            'admin_unread_count' => 1,
            'customer_unread_count' => 0,
        ]);

        // Customer's initial message
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'customer',
            'sender_name' => $validated['customer_name'],
            'message' => $validated['initial_message'],
            'is_read' => false,
        ]);

        // Automated Studio Concierge Greeting
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'system',
            'sender_name' => 'Dezzly Concierge',
            'message' => "Halo kak {$session->customer_name}! Selamat datang di ruang negosiasi resmi Dezzly Creative. Tim produser kami sedang membaca pesan Anda. Silakan sampaikan rincian acara atau penawaran yang diinginkan.",
            'is_read' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'session_token' => $session->session_token,
            'session_code' => $session->session_code,
            'session' => [
                'id' => $session->id,
                'customer_name' => $session->customer_name,
                'package_name' => $session->package_name,
                'status' => $session->status,
                'is_deal' => false,
            ],
            'messages' => $session->messages()->get(),
        ]);
    }

    /**
     * Retrieve active session data and history for visitor.
     */
    public function getSession(string $token): JsonResponse
    {
        $session = ChatSession::where('session_token', $token)->first();

        if (! $session) {
            return response()->json(['status' => 'not_found'], 404);
        }

        // Mark admin/system messages as read by customer
        ChatMessage::where('chat_session_id', $session->id)
            ->whereIn('sender_type', ['admin', 'system'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $session->update(['customer_unread_count' => 0]);

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
                'whatsapp_deal_url' => $session->isDeal() ? $session->getWhatsAppDealUrl() : null,
                'deal_at' => $session->deal_at?->format('d/m/Y H:i'),
                'days_until_prune' => $session->daysUntilPrune(),
            ],
            'messages' => $session->messages()->get(),
        ]);
    }

    /**
     * Polling endpoint for visitor to get new messages in real-time.
     */
    public function pollMessages(Request $request, string $token): JsonResponse
    {
        $session = ChatSession::where('session_token', $token)->first();

        if (! $session) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $lastId = (int) $request->query('last_id', 0);

        $query = ChatMessage::where('chat_session_id', $session->id);
        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->orderBy('id', 'asc')->get();

        if ($messages->isNotEmpty()) {
            ChatMessage::where('chat_session_id', $session->id)
                ->whereIn('sender_type', ['admin', 'system'])
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $session->update(['customer_unread_count' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'session_status' => $session->status,
            'is_deal' => $session->isDeal(),
            'whatsapp_deal_url' => $session->isDeal() ? $session->getWhatsAppDealUrl() : null,
            'messages' => $messages,
        ]);
    }

    /**
     * Send a new message from visitor.
     */
    public function sendMessage(Request $request, string $token): JsonResponse
    {
        $session = ChatSession::where('session_token', $token)->first();

        if (! $session) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender_type' => 'customer',
            'sender_name' => $session->customer_name,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $session->increment('admin_unread_count');
        $session->update(['last_message_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}
