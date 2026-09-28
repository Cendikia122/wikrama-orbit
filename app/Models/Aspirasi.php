<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     */
    protected $table = 'aspirasi';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'judul',
        'isi',
        'nama_pengirim',
        'email_pengirim',
        'role_pengirim',
        'status',
        'tanggapan',
        'is_publik',
    ];
}
