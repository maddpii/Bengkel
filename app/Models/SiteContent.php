<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_image',
        'hero_primary_cta_text',
        'hero_primary_cta_link',
        'hero_secondary_cta_text',
        'hero_secondary_cta_link',
        'hero_highlight_1',
        'hero_highlight_2',
        'hero_highlight_3',
        'about_text',
        'extra_info',
        'gallery_images',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            [
                'hero_badge' => 'Servis Mobil Tepercaya',
                'hero_title' => 'Bengkel Mobil',
                'hero_subtitle' => 'Servis terpercaya untuk kendaraan Anda',
                'hero_description' => 'Perawatan berkala, pengecekan menyeluruh, dan penggantian sparepart dengan proses yang rapi dan transparan.',
                'hero_primary_cta_text' => 'Booking Sekarang',
                'hero_primary_cta_link' => '/bookings/create',
                'hero_secondary_cta_text' => 'Tentang Bengkel',
                'hero_secondary_cta_link' => '#about',
                'hero_highlight_1' => 'Mekanik berpengalaman',
                'hero_highlight_2' => 'Sparepart berkualitas',
                'hero_highlight_3' => 'Booking cepat dan mudah',
                'about_text' => 'Kami melayani perawatan dan perbaikan mobil dengan mekanik berpengalaman.',
                'extra_info' => 'Jam operasional: Senin-Sabtu 08:00-17:00',
                'gallery_images' => [],
            ]
        );
    }
}
