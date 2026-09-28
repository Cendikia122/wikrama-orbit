<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AbsensiGds extends Model {
    protected $table = 'absensi_gds';
    protected $fillable = [
        'tanggal', 'hari', 'nama_anggota', 'divisi', 'jobdesk',
        'penempatan', 'status_kehadiran', 'poin_pelanggaran', 'catatan', 'dicatat_oleh'
    ];
    protected $casts = ['tanggal' => 'date'];
}
