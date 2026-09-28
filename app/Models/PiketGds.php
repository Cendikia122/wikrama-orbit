<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiketGds extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     * bidang_petugas is a plain integer, not a FK constraint.
     */
    protected $table = 'piket_gds';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tanggal',
        'hari',
        'nama_petugas',
        'jabatan_petugas',
        'bidang_petugas',
        'shift',
        'jobdesk',
        'penempatan',
        'divisi',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal' => 'date',
    ];
}
