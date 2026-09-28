<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveEventOption extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     * live_event_id is a plain integer reference, not a FK constraint.
     */
    protected $table = 'live_event_options';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'live_event_id',
        'nama_kandidat',
        'foto',
        'deskripsi',
        'jumlah_suara',
    ];
}
