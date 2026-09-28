<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds Kanban & project-tracking columns to kegiatan_osis.
     * bidang_pic is a plain number — NO FOREIGN KEY constraint.
     */
    public function up(): void
    {
        Schema::table('kegiatan_osis', function (Blueprint $table) {
            $table->string('kanban_status')->default('todo')->after('status');
            // 'todo','inprogress','blocked','done'
            $table->string('prioritas')->default('normal')->after('kanban_status');
            // 'rendah','normal','tinggi','kritis'
            $table->tinyInteger('bidang_pic')->nullable()->after('prioritas');
            // which sekbid owns this (plain number, NO FK)
            $table->tinyInteger('persentase_selesai')->default(0)->after('bidang_pic');
            // 0-100 progress percentage
            $table->string('nama_ketua_pelaksana')->nullable()->after('persentase_selesai');
            // plain text event organizer name, NO FK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan_osis', function (Blueprint $table) {
            $table->dropColumn([
                'kanban_status',
                'prioritas',
                'bidang_pic',
                'persentase_selesai',
                'nama_ketua_pelaksana',
            ]);
        });
    }
};
