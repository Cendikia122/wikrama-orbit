<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * FLAT TABLE — NO FOREIGN KEYS (Exam Compliance).
     * kegiatan_id is a plain number reference, no FK constraint.
     */
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kegiatan_id');      // plain number, NO FK constraint
            $table->string('judul_kegiatan');               // plain text copy of kegiatan title
            $table->string('jenis');                        // 'pemasukan','pengeluaran'
            $table->string('kategori');                     // 'Konsumsi','Transportasi','Perlengkapan','Lain-lain'
            $table->unsignedBigInteger('jumlah');           // IDR Rupiah amount
            $table->text('keterangan');
            $table->string('bukti_foto')->nullable();       // filename
            $table->string('dicatat_oleh');                 // plain text name, NO FK
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {
        Schema::dropIfExists('keuangan');
    }
};
