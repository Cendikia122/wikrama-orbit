<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FLAT TABLE — NO FOREIGN KEYS (Exam Compliance).
     */
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->text('isi');
            $table->string('nama_pengirim');          // plain text, NOT FK
            $table->string('email_pengirim')->nullable();
            $table->string('role_pengirim')->default('warga'); // display context only
            $table->string('status')->default('menunggu');     // 'menunggu','diproses','selesai'
            $table->text('tanggapan')->nullable();             // MPR response
            $table->boolean('is_publik')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
