<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaintiffRepresentative extends Model
{
    public $fillable = ['name'];

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
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
