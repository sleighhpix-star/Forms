<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key, with optional default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("setting:{$key}", function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Set (upsert) a setting value and clear its cache.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    /**
     * Return all signatory defaults as an array keyed by field name.
     */
    public static function signatories(): array
    {
        $keys = [
            'sig_requested_name', 'sig_requested_position',
            'sig_reviewed_name', 'sig_reviewed_position',
            'sig_recommending_name', 'sig_recommending_position',
            'sig_approved_name', 'sig_approved_position',
        ];

        return static::whereIn('key', $keys)
            ->pluck('value', 'key')
            ->all();
    }
}
