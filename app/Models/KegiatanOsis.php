<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanOsis extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     */
    protected $table = 'kegiatan_osis';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'penanggung_jawab',
        'kategori',
        'target_selesai',
        'status',
        'done_time',
        'catatan_evaluasi',
        // Kanban & project tracking fields
        'kanban_status',          // 'todo','inprogress','blocked','done'
        'prioritas',              // 'rendah','normal','tinggi','kritis'
        'bidang_pic',             // plain integer sekbid number, NO FK
        'persentase_selesai',     // 0-100 progress percentage
        'nama_ketua_pelaksana',   // plain text event organizer name, NO FK
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'target_selesai'      => 'datetime',
        'done_time'           => 'datetime',
        'status'              => 'boolean',
        'persentase_selesai'  => 'integer',
        'bidang_pic'          => 'integer',
    ];
}
