<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FLAT TABLE — NO FOREIGN KEYS (Exam Compliance).
     * live_event_id is a plain number reference, no FK constraint.
     */
    public function up(): void
    {
        Schema::create('live_event_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('live_event_id'); // plain number, NO FK constraint
            $table->string('nama_kandidat');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('jumlah_suara')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_event_options');
    }
};
