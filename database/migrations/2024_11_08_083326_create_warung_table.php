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
        Schema::create('warung', function (Blueprint $table) {
            $table->id('warung_id');
            $table->string('nama_warung', 100);
            $table->string('slug', 100)->unique();
            $table->string('alamat', 255)->nullable();
            $table->string('no_wa', 15);
            $table->enum('status_pengantaran', ['aktif', 'tidak aktif'])->default('aktif');
            $table->string('image')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Tambahkan kolom user_id dengan foreign key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warung');
    }
};