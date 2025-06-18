<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('our_impacts', function (Blueprint $table) {
            $table->id();
            $table->json('title_1');
            $table->json('subtitle_1');
            $table->json('title_2');
            $table->json('subtitle_2');
            $table->json('title_3');
            $table->json('subtitle_3');
            $table->json('title_4');
            $table->json('subtitle_4');
            $table->json('sdg_title');
            $table->string('image');
            $table->json('sub_icons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_impacts');
    }
};
