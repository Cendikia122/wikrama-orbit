<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveEventVote extends Model
{
    /**
     * The table associated with the model.
     * FLAT TABLE — NO FOREIGN KEYS, NO RELATIONS (Exam Compliance).
     * All IDs are plain integer references, not FK constraints.
     */
    protected $table = 'live_event_votes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'live_event_id',
        'option_id',
        'voter_username',
        'voter_name',
    ];
}
