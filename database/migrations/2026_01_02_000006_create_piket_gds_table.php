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
        Schema::create('piket_gds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal');
            $table->string('hari');                         // 'Senin','Selasa', etc.
            $table->string('nama_petugas');                 // plain text, NO FK
            $table->string('jabatan_petugas');              // plain text, NO FK
            $table->tinyInteger('bidang_petugas')->nullable(); // plain number, NO FK
            $table->string('shift')->default('Pagi');       // 'Pagi','Sore'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piket_gds');
    }
};
