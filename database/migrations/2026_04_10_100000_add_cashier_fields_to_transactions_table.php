<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('manual_service_name')->nullable()->after('total_service');
            $table->decimal('manual_service_price', 12, 2)->default(0)->after('manual_service_name');
            $table->text('cashier_notes')->nullable()->after('manual_service_price');
            $table->timestamp('processed_at')->nullable()->after('cashier_notes');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'manual_service_name',
                'manual_service_price',
                'cashier_notes',
                'processed_at',
            ]);
        });
    }
};
