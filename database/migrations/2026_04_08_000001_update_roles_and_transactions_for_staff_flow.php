<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','mekanik','kasir','customer','owner') NOT NULL");

        Schema::table('transactions', function (Blueprint $table) {
            $table->text('work_summary')->nullable()->after('grand_total');
            $table->text('work_recommendation')->nullable()->after('work_summary');
            $table->timestamp('completed_at')->nullable()->after('work_recommendation');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['work_summary', 'work_recommendation', 'completed_at']);
        });

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','mekanik','kasir','customer') NOT NULL");
    }
};
