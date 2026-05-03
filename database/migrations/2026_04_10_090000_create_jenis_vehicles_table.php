<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('brand')->unique();
            $table->timestamps();
        });

        $brands = DB::table('vehicles')
            ->whereNotNull('brand')
            ->select('brand', DB::raw('MIN(user_id) as user_id'), DB::raw('MIN(created_at) as created_at'), DB::raw('MAX(updated_at) as updated_at'))
            ->groupBy('brand')
            ->get();

        foreach ($brands as $brand) {
            DB::table('jenis_vehicles')->insert([
                'user_id' => $brand->user_id,
                'brand' => $brand->brand,
                'created_at' => $brand->created_at ?? now(),
                'updated_at' => $brand->updated_at ?? now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_vehicles');
    }
};
