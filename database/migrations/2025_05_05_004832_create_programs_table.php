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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('implementing_partner');
            $table->string('sector');
            $table->string('slug');
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('youtube_link')->nullable();
            $table->string('banner')->nullable();
            $table->json('description');
            $table->string('document');

            $table->unsignedBigInteger('program_category_id')->nullable();
            $table->foreign('program_category_id')->references('id')->on('program_categories')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
