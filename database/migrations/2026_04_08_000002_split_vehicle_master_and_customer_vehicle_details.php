<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('model')->nullable()->change();
            $table->year('year')->nullable()->change();
            $table->string('license_plate')->nullable()->change();
            $table->string('color')->nullable()->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('customer_vehicle_model')->after('vehicle_id');
            $table->string('customer_license_plate')->after('customer_vehicle_model');
            $table->string('customer_vehicle_color')->after('customer_license_plate');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_vehicle_model',
                'customer_license_plate',
                'customer_vehicle_color',
            ]);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('model')->nullable(false)->change();
            $table->year('year')->nullable(false)->change();
            $table->string('license_plate')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
        });
    }
};
