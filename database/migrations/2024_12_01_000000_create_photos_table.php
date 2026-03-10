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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('student_name');
            $table->string('year_level');
            $table->text('description')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->boolean('is_outfit')->default(false);
            $table->timestamps();
        });

        Schema::create('photo_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->timestamps();

            $table->unique(['photo_id', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_likes');
        Schema::dropIfExists('photos');
    }
};
