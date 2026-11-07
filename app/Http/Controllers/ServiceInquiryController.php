<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\ServiceInquiry;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceInquiryController extends Controller
{
    /**
     * Store a new event documentation service inquiry and generate WhatsApp redirect URL.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:50'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'service_type' => ['required', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'venue_location' => ['nullable', 'string', 'max:255'],
            'estimated_budget' => ['nullable', 'string', 'max:255'],
            'brief_notes' => ['nullable', 'string', 'max:1500'],
        ]);

        $inquiryCode = 'DZY-INQ-'.strtoupper(Str::random(6));

        $package = ! empty($validated['package_id']) ? Package::find($validated['package_id']) : null;

        $inquiry = ServiceInquiry::create([
            'inquiry_code' => $inquiryCode,
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'customer_email' => $validated['customer_email'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'package_id' => $package?->id,
            'service_type' => $validated['service_type'],
            'event_date' => $validated['event_date'] ?? null,
            'venue_location' => $validated['venue_location'] ?? null,
            'estimated_budget' => $validated['estimated_budget'] ?? null,
            'brief_notes' => $validated['brief_notes'] ?? null,
            'status' => 'new',
        ]);

        $adminPhone = config('app.whatsapp_number', '6282146031398');
        $dateStr = $inquiry->event_date ? Carbon::parse($inquiry->event_date)->isoFormat('D MMMM Y') : 'Menyesuaikan';

        $message = "Halo Dezzly Creative, saya tertarik memesan jasa dokumentasi & produksi:\n"
            ."• Kode Inquiry: *{$inquiryCode}*\n"
            ."• Nama: {$inquiry->customer_name}".($inquiry->company_name ? " ({$inquiry->company_name})\n" : "\n")
            .'• Layanan: *'.($package ? $package->name : $inquiry->service_type)."*\n"
            .($package ? "• Investasi Paket: {$package->formatted_price}/day\n" : '')
            ."• Rencana Tanggal Acara: {$dateStr}\n"
            .($inquiry->venue_location ? "• Lokasi/Venue: {$inquiry->venue_location}\n" : '')
            .($inquiry->estimated_budget ? "• Estimasi Budget: {$inquiry->estimated_budget}\n" : '')
            .($inquiry->brief_notes ? "• Brief/Kebutuhan: {$inquiry->brief_notes}\n" : '')
            ."\nMohon info ketersediaan tim dan pengiriman quotation resminya. Terima kasih!";

        $whatsappUrl = 'https://wa.me/'.$adminPhone.'?text='.urlencode($message);

        return response()->json([
            'success' => true,
            'inquiry_code' => $inquiryCode,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}
