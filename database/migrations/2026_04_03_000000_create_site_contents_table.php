<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('about_text')->nullable();
            $table->text('extra_info')->nullable();
            $table->json('gallery_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
