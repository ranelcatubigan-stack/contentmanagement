<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->string('photo')->nullable(); // stored path
            $table->string('category')->default('General');
            $table->integer('likes_count')->default(0);
            $table->timestamps();
        });

        Schema::create('news_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('news_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unique(['news_id', 'user_id']); // one like per user
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_likes');
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('news');
    }
};