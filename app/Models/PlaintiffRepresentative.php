<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaintiffRepresentative extends Model
{
    public $fillable = ['name', 'submitter_id', 'lawsuit_id'];

    /**
     * Get lawsuit for the Plaintiff Representative.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }

    /**
     * Get type author for the Plaintiff Representative.
     */
    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
