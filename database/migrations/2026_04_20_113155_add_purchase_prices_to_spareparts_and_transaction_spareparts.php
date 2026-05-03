<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spareparts', function (Blueprint $table) {
            $table->decimal('purchase_price', 12, 2)->default(0)->after('stock');
        });

        DB::table('spareparts')->update([
            'purchase_price' => DB::raw('price'),
        ]);

        Schema::table('transaction_spareparts', function (Blueprint $table) {
            $table->decimal('purchase_price', 12, 2)->default(0)->after('price');
        });

        DB::table('transaction_spareparts')
            ->join('spareparts', 'spareparts.id', '=', 'transaction_spareparts.sparepart_id')
            ->update([
                'transaction_spareparts.purchase_price' => DB::raw('spareparts.purchase_price'),
            ]);
    }

    public function down(): void
    {
        Schema::table('transaction_spareparts', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });

        Schema::table('spareparts', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });
    }
};
