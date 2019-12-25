<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherParty extends Model
{
    public $fillable = ['name'];

    /**
     * Get case for the other party.
     */
    public function case()
    {
        return $this->belongsTo('App\Models\Cases', 'cases_id');
    }

    /**
     * Get type author for the other party.
     */
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
