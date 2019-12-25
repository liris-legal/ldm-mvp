<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaintiffRepresentative extends Model
{
    public $fillable = ['name'];

    /**
     * Get case for the Plaintiff Representative.
     */
    public function case()
    {
        return $this->belongsTo('App\Models\Cases', 'cases_id');
    }

    /**
     * Get type author for the Plaintiff Representative.
     */
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
