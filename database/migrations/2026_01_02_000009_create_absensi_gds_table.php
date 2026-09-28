<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absensi_gds', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('hari', 10); // Senin, Selasa, dll
            $table->string('nama_anggota'); // plain text, NO FK
            $table->string('divisi'); // DH, MPR, SEKBID 1, etc.
            $table->string('jobdesk')->nullable(); // SIM, Tas, Pengawas, dll
            $table->string('penempatan')->nullable(); // Parkiran, Belakang
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'terlambat'])->default('hadir');
            $table->integer('poin_pelanggaran')->default(0); // numeric value like 3
            $table->text('catatan')->nullable();
            $table->string('dicatat_oleh')->nullable(); // who marked it
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('absensi_gds');
    }
};
