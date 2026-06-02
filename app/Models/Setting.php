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

    // Default values for all settings
    public static array $defaults = [
        'whatsapp_number'       => '6281234567890',
        'whatsapp_message'      => 'Halo Juragan Otomotif, saya tertarik dengan [Nama Mobil] [Tahun]. Bisa info lebih lanjut?',
        'instagram_url'         => '',
        'tiktok_url'            => '',
        'hero_title'            => 'Temukan Mobil Bekas Impian Anda',
        'hero_subtitle'         => 'Koleksi mobil berkualitas dengan harga terbaik. Tersedia berbagai pilihan dari berbagai merek terpercaya.',
        'logo_path'             => '',
        'alamat'                => '',
        'jam_operasional'       => 'Senin - Sabtu: 08.00 - 17.00 WIB',
        'meta_title_home'       => 'Juragan Otomotif – Jual Beli Mobil Bekas Terpercaya',
        'meta_desc_home'        => 'Platform jual beli mobil bekas terpercaya. Temukan berbagai pilihan mobil bekas berkualitas dengan harga terbaik.',
    ];

    /**
     * Get a setting value by key, with cache
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return static::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default ?? (static::$defaults[$key] ?? null);
    }

    /**
     * Set a setting value and clear cache
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    /**
     * Set multiple settings at once
     */
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
