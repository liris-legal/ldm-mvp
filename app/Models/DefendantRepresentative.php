<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefendantRepresentative extends Model
{
    public $fillable = ['name', 'submitter_id', 'lawsuit_id'];

    /**
     * Get lawsuit for the Defendant Representative.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\lawsuit', 'lawsuit_id');
    }

    /**
     * Get type author for the Defendant Representative.
     */
    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }
}
