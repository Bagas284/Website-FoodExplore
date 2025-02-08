<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('ulasan_id');  // Primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('warung_id');
            $table->unsignedTinyInteger('rating');  // Rating antara 1-5
            $table->text('komentar')->nullable();
            $table->timestamps();  // Laravel default timestamps

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('warung_id')->references('warung_id')->on('warung')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
