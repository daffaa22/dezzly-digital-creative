<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'category',
        'sensor_type',
        'mount_type',
        'daily_price',
        'requires_fe_lens',
        'description',
        'specifications',
        'image_url',
        'is_available',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'daily_price' => 'integer',
            'requires_fe_lens' => 'boolean',
            'is_available' => 'boolean',
            'specifications' => 'array',
        ];
    }

    /**
     * Orders associated with this item.
     */
    public function rentalOrders(): HasMany
    {
        return $this->hasMany(RentalOrder::class, 'rental_item_id');
    }

    /**
     * Get formatted price in Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format($this->daily_price, 0, ',', '.');
    }
}
