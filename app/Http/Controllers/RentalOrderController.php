<?php

namespace App\Http\Controllers;

use App\Models\RentalItem;
use App\Models\RentalOrder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RentalOrderController extends Controller
{
    /**
     * Store a newly created rental booking and generate WhatsApp redirect URL.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:50'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'rental_item_id' => ['required', 'exists:rental_items,id'],
            'lens_item_id' => ['nullable', 'exists:rental_items,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $camera = RentalItem::findOrFail($validated['rental_item_id']);
        $lens = ! empty($validated['lens_item_id']) ? RentalItem::find($validated['lens_item_id']) : null;

        // Check if camera requires FE lens
        if ($camera->requires_fe_lens && ! $lens) {
            return response()->json([
                'success' => false,
                'message' => 'Kamera seri Full Frame (A7-Series) wajib menyewa lensa tambahan (Sony FE).',
            ], 422);
        }

        $dailyTotal = $camera->daily_price + ($lens ? $lens->daily_price : 0);
        $grandTotal = $dailyTotal * (int) $validated['duration_days'];

        $orderCode = 'DZY-RENT-'.strtoupper(Str::random(6));

        $order = RentalOrder::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'customer_email' => $validated['customer_email'] ?? null,
            'rental_item_id' => $camera->id,
            'lens_item_id' => $lens?->id,
            'start_date' => $validated['start_date'],
            'duration_days' => $validated['duration_days'],
            'total_price' => $grandTotal,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Build WhatsApp Message
        $adminPhone = config('app.whatsapp_number', '6281234567890');
        $formattedDate = Carbon::parse($order->start_date)->isoFormat('D MMMM Y');
        $formattedTotal = 'Rp '.number_format($grandTotal, 0, ',', '.');

        $message = "Halo Dezzly Creative, saya ingin konfirmasi sewa kamera:\n"
            ."• Kode Booking: *{$orderCode}*\n"
            ."• Nama: {$order->customer_name}\n"
            ."• Kamera: *{$camera->name}*\n"
            .($lens ? "• Lensa: *{$lens->name}*\n" : "• Lensa: Kit / Tanpa Lensa Tambahan\n")
            ."• Mulai Sewa: {$formattedDate}\n"
            ."• Durasi: {$order->duration_days} Hari (24 Jam x {$order->duration_days})\n"
            ."• Estimasi Total: *{$formattedTotal}*\n"
            .($order->notes ? "• Catatan: {$order->notes}\n" : '')
            ."\nMohon konfirmasi ketersediaan unit dan persyaratan sewanya ya. Terima kasih!";

        $whatsappUrl = 'https://wa.me/'.$adminPhone.'?text='.urlencode($message);

        return response()->json([
            'success' => true,
            'order_code' => $orderCode,
            'total_price_formatted' => $formattedTotal,
            'redirect_url' => $whatsappUrl,
        ]);
    }
}
