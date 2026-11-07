<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_code',
        'session_token',
        'customer_name',
        'customer_whatsapp',
        'package_id',
        'package_name',
        'initial_notes',
        'agreed_price',
        'event_date',
        'venue_location',
        'deal_notes',
        'deal_at',
        'status',
        'admin_unread_count',
        'customer_unread_count',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'agreed_price' => 'decimal:2',
            'event_date' => 'date',
            'deal_at' => 'datetime',
            'last_message_at' => 'datetime',
            'admin_unread_count' => 'integer',
            'customer_unread_count' => 'integer',
        ];
    }

    /**
     * Relationship: All messages in this session.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('id', 'asc');
    }

    /**
     * Relationship: Related package if specified.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Generate unique session code and token on creation.
     */
    public static function createNewSession(array $attributes): self
    {
        $code = 'CHAT-'.strtoupper(Str::random(6));
        while (self::where('session_code', $code)->exists()) {
            $code = 'CHAT-'.strtoupper(Str::random(6));
        }

        $token = Str::random(40);

        return self::create(array_merge([
            'status' => 'active',
            'last_message_at' => now(),
        ], $attributes, [
            'session_code' => $code,
            'session_token' => $token,
        ]));
    }

    /**
     * Check if this chat session has reached a deal.
     */
    public function isDeal(): bool
    {
        return $this->status === 'deal';
    }

    /**
     * Days remaining until auto-deletion (policy: 60 days after deal).
     */
    public function daysUntilPrune(): ?int
    {
        if (! $this->isDeal() || ! $this->deal_at) {
            return null;
        }

        $daysPassed = $this->deal_at->diffInDays(now());

        return max(0, 60 - (int) $daysPassed);
    }

    /**
     * Format WhatsApp URL containing the agreed deal details.
     */
    public function getWhatsAppDealUrl(): string
    {
        $waRaw = SiteSetting::get('whatsapp_number', '0821-4603-1398');
        $waDigits = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($waDigits, '0')) {
            $waIntl = '62'.substr($waDigits, 1);
        } else {
            $waIntl = $waDigits;
        }

        $priceFormatted = $this->agreed_price
            ? 'Rp '.number_format($this->agreed_price, 0, ',', '.')
            : 'Menyesuaikan Diskusi';

        $eventDateFormatted = $this->event_date
            ? $this->event_date->format('d/m/Y')
            : 'Menyesuaikan';

        $text = "Halo Dezzly Creative Studio,\n\n"
            ."Saya telah mencapai KESEPAKATAN (DEAL) melalui Live Chat Negosiasi Studio:\n\n"
            ."• Kode Chat: {$this->session_code}\n"
            ."• Klien: {$this->customer_name}\n"
            ."• No WhatsApp: {$this->customer_whatsapp}\n"
            .'• Paket: '.($this->package_name ?: ($this->package ? $this->package->name : 'Paket Kustom'))."\n"
            ."• Kesepakatan Harga: {$priceFormatted}\n"
            ."• Rencana Tanggal: {$eventDateFormatted}\n"
            .'• Lokasi Acara: '.($this->venue_location ?: 'Menyesuaikan')."\n"
            .($this->deal_notes ? "• Catatan Kesepakatan: {$this->deal_notes}\n" : '')
            ."\nMohon konfirmasi penguncian jadwal dan pembuatan invoice resmi. Terima kasih!";

        return 'https://wa.me/'.$waIntl.'?text='.rawurlencode($text);
    }

    /**
     * Scope for querying expired deals (over 60 days).
     */
    public function scopeExpiredDeals($query, int $days = 60)
    {
        return $query->where('status', 'deal')
            ->whereNotNull('deal_at')
            ->where('deal_at', '<=', now()->subDays($days));
    }
}
