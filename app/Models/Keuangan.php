<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     * kegiatan_id is a plain integer reference, not a FK constraint.
     */
    protected $table = 'keuangan';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kegiatan_id',
        'judul_kegiatan',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'bukti_foto',
        'dicatat_oleh',
    ];
}
