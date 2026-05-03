<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->after('submitted_at');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_status')->nullable()->after('midtrans_transaction_id');
            $table->text('snap_token')->nullable()->after('midtrans_status');
            $table->json('midtrans_response')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_status',
                'snap_token',
                'midtrans_response',
            ]);
        });
    }
};
