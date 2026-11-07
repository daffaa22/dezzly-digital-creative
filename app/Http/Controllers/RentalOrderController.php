<?php

namespace App\Http\Controllers;

use App\Models\RentalItem;
use App\Models\RentalOrder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'rental_item_id' => [
                'required',
                Rule::exists('rental_items', 'id')
                    ->where(fn ($query) => $query->where('category', 'camera')->where('is_available', true)),
            ],
            'lens_item_id' => [
                'nullable',
                Rule::exists('rental_items', 'id')
                    ->where(fn ($query) => $query->where('category', 'lens')->where('is_available', true)),
            ],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'rental_item_id.exists' => 'Unit kamera yang dipilih tidak tersedia atau sedang tidak bisa disewa.',
            'lens_item_id.exists' => 'Lensa yang dipilih tidak tersedia atau bukan kategori lensa.',
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

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = $startDate->copy()->addDays((int) $validated['duration_days'] - 1);

        foreach (array_filter([$camera, $lens]) as $item) {
            if ($this->hasScheduleConflict($item, $startDate, $endDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit "'.$item->name.'" sudah dibooking pada tanggal tersebut. Silakan pilih tanggal atau unit lain.',
                ], 422);
            }
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
        $adminPhone = config('app.whatsapp_number', '6282146031398');
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
            'whatsapp_url' => $whatsappUrl,
        ]);
    }

    /**
     * Determine whether an item already has a confirmed/active booking overlapping the period.
     */
    private function hasScheduleConflict(RentalItem $item, Carbon $startDate, Carbon $endDate): bool
    {
        return RentalOrder::query()
            ->where(function ($query) use ($item) {
                $query->where('rental_item_id', $item->id)
                    ->orWhere('lens_item_id', $item->id);
            })
            ->whereIn('status', ['confirmed', 'active'])
            ->whereDate('start_date', '<=', $endDate)
            ->get()
            ->contains(function (RentalOrder $order) use ($startDate) {
                $orderEnd = Carbon::parse($order->start_date)->startOfDay()
                    ->addDays($order->duration_days - 1);

                return $orderEnd->greaterThanOrEqualTo($startDate);
            });
    }
}
