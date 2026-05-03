<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('services')->exists()) {
            return;
        }

        $now = now();

        DB::table('services')->insert([
            [
                'service_name' => 'Ganti Oli',
                'price' => 150000,
                'estimated_time' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_name' => 'Tune Up',
                'price' => 350000,
                'estimated_time' => 90,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_name' => 'Servis Rem',
                'price' => 250000,
                'estimated_time' => 60,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'service_name' => 'Servis AC',
                'price' => 300000,
                'estimated_time' => 75,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->whereIn('service_name', ['Ganti Oli', 'Tune Up', 'Servis Rem', 'Servis AC'])
            ->delete();
    }
};
