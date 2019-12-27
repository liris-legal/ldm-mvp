<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defendant extends Model
{
    public $fillable = ['name'];

    /**
     * Get lawsuit for the Defendant.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\lawsuits', 'lawsuit_id');
    }

    /**
     * Get type author for the Defendant.
     */
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
