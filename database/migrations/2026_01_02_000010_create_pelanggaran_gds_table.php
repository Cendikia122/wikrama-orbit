<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pelanggaran_gds', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam')->nullable();
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->string('jurusan')->nullable();
            $table->string('jenis_pelanggaran'); // dropdown value
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('tingkat_keparahan', ['ringan', 'sedang', 'berat'])->default('ringan');
            $table->string('dicatat_oleh'); // petugas piket name
            $table->string('jabatan_pencatat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pelanggaran_gds');
    }
};
