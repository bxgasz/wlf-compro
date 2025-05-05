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
        Schema::create('news_stories', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title');
            $table->string('meta_description');
            $table->json('title');
            $table->enum('type', ['story', 'news']);
            $table->string('slug');
            $table->json('content');
            $table->string('banner');
            $table->string('writter');

            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->unsignedBigInteger('editor_by')->nullable();
            $table->foreign('editor_by')->references('id')->on('users')->onDelete('set null');

            $table->enum('status', ['published', 'draft']);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('tags_news_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->foreignId('news_stories_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_stories');
        Schema::dropIfExists('tags_news_stories');
    }
};
