<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PelanggaranGds extends Model {
    protected $table = 'pelanggaran_gds';
    protected $fillable = [
        'tanggal', 'jam', 'nama_siswa', 'kelas', 'jurusan',
        'jenis_pelanggaran', 'keterangan_tambahan', 'tingkat_keparahan',
        'dicatat_oleh', 'jabatan_pencatat'
    ];
    protected $casts = ['tanggal' => 'date'];
}
