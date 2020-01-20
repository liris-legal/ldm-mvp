<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plaintiff extends Model
{
    public $fillable = ['name', 'lawsuit_id', 'submitter_id'];

    /**
     * Get lawsuit for the Plaintiff.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }

    /**
     * Get the plaintiff's documents.
     */
    public function documents()
    {
        // return $this->hasMany('App\Models\Document');
        return $this->morphMany('App\Models\Document', 'documentable');
    }

    /**
     * Get submitter for the Plaintiff.
     */
    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
