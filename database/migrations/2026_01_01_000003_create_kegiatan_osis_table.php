<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     */
    public function up(): void
    {
        Schema::create('kegiatan_osis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('penanggung_jawab');
            $table->string('kategori');
            $table->dateTime('target_selesai');
            $table->boolean('status')->default(0);
            $table->dateTime('done_time')->nullable();
            $table->text('catatan_evaluasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_osis');
    }
};
