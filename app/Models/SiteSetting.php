<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
    ];

    /**
     * Get a setting value by key with caching.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::getAllCached();

        return $all[$key] ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, ?string $value, string $group = 'general', ?string $label = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget('dezzly_site_settings');
    }

    /**
     * Get all settings from cache as key => value pair.
     *
     * @return array<string, string|null>
     */
    public static function getAllCached(): array
    {
        return Cache::rememberForever('dezzly_site_settings', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear the settings cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('dezzly_site_settings');
    }
}
