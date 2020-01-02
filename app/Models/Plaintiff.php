<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plaintiff extends Model
{
    public $fillable = ['name', 'submitter_id', 'lawsuit_id'];

    /**
     * Get lawsuit for the Plaintiff.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }

    /**
     * Get type author for the Plaintiff.
     */
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
