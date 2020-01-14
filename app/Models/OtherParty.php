<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherParty extends Model
{
    public $fillable = ['name', 'lawsuit_id'];

    /**
     * Get case for the other party.
     */
    public function case()
    {
        return $this->belongsTo('App\Models\Cases', 'cases_id');
    }
}
