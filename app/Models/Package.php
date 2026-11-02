<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
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
        'subtitle',
        'price_daily',
        'base_gear',
        'crew_fg_count',
        'crew_vg_count',
        'has_drone',
        'turnaround_days',
        'photo_output',
        'video_output',
        'features',
        'is_popular',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_daily' => 'integer',
            'crew_fg_count' => 'integer',
            'crew_vg_count' => 'integer',
            'has_drone' => 'boolean',
            'turnaround_days' => 'integer',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'array',
        ];
    }

    /**
     * Inquiries referencing this package.
     */
    public function serviceInquiries(): HasMany
    {
        return $this->hasMany(ServiceInquiry::class);
    }

    /**
     * Formatted price attribute.
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_daily === 0) {
            return 'Custom Quotation';
        }

        return 'Rp '.number_format($this->price_daily, 0, ',', '.');
    }
}
