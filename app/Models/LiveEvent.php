<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveEvent extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     */
    protected $table = 'live_events';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'jenis',
        'status',
        'mulai_at',
        'selesai_at',
        'dibuat_oleh',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'mulai_at'   => 'datetime',
        'selesai_at' => 'datetime',
    ];
}
