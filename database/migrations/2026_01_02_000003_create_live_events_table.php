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
        Schema::create('live_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('jenis');                         // 'pemilu','lomba','voting_umum'
            $table->string('status')->default('akan_datang'); // 'akan_datang','berlangsung','selesai'
            $table->dateTime('mulai_at')->nullable();
            $table->dateTime('selesai_at')->nullable();
            $table->string('dibuat_oleh');                   // plain text name, NO FK
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_events');
    }
};
