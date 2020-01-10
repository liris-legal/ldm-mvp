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
    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }

    /**
     * Get documents for plaintiff.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
