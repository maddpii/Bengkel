<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->string('hero_badge')->nullable()->after('id');
            $table->text('hero_description')->nullable()->after('hero_subtitle');
            $table->string('hero_primary_cta_text')->nullable()->after('hero_image');
            $table->string('hero_primary_cta_link')->nullable()->after('hero_primary_cta_text');
            $table->string('hero_secondary_cta_text')->nullable()->after('hero_primary_cta_link');
            $table->string('hero_secondary_cta_link')->nullable()->after('hero_secondary_cta_text');
            $table->string('hero_highlight_1')->nullable()->after('hero_secondary_cta_link');
            $table->string('hero_highlight_2')->nullable()->after('hero_highlight_1');
            $table->string('hero_highlight_3')->nullable()->after('hero_highlight_2');
        });

        DB::table('site_contents')->update([
            'hero_badge' => 'Servis Mobil Tepercaya',
            'hero_description' => 'Perawatan berkala, pengecekan menyeluruh, dan penggantian sparepart dengan proses yang rapi dan transparan.',
            'hero_primary_cta_text' => 'Booking Sekarang',
            'hero_primary_cta_link' => '/bookings/create',
            'hero_secondary_cta_text' => 'Tentang Bengkel',
            'hero_secondary_cta_link' => '#about',
            'hero_highlight_1' => 'Mekanik berpengalaman',
            'hero_highlight_2' => 'Sparepart berkualitas',
            'hero_highlight_3' => 'Booking cepat dan mudah',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->dropColumn([
                'hero_badge',
                'hero_description',
                'hero_primary_cta_text',
                'hero_primary_cta_link',
                'hero_secondary_cta_text',
                'hero_secondary_cta_link',
                'hero_highlight_1',
                'hero_highlight_2',
                'hero_highlight_3',
            ]);
        });
    }
};
