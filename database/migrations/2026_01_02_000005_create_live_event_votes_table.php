<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FLAT TABLE — NO FOREIGN KEYS (Exam Compliance).
     * All IDs are plain numbers, no FK constraints.
     */
    public function up(): void
    {
        Schema::create('live_event_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('live_event_id');  // plain number, NO FK
            $table->unsignedBigInteger('option_id');       // plain number, NO FK
            $table->string('voter_username');              // plain text, NO FK
            $table->string('voter_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_event_votes');
    }
};
