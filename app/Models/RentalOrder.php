<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_whatsapp',
        'customer_email',
        'rental_item_id',
        'lens_item_id',
        'start_date',
        'duration_days',
        'total_price',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'duration_days' => 'integer',
            'total_price' => 'integer',
        ];
    }

    public function camera(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class, 'rental_item_id');
    }

    public function lens(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class, 'lens_item_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format($this->total_price, 0, ',', '.');
    }
}
