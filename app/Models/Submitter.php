<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submitter extends Model
{
    public $fillable = ['name'];

    /**
     * Get all plaintiffs for submitter.
     */
    public function plaintiffs()
    {
        return $this->hasMany('App\Models\Plaintiff');
    }

    /**
     * Get all plaintiffs for submitter.
     */
    public function plaintiffRepresentatives()
    {
        return $this->hasMany('App\Models\PlaintiffRepresentative');
    }

    /**
     * Get all plaintiffs for submitter.
     */
    public function defendants()
    {
        return $this->hasMany('App\Models\Defendant');
    }

    /**
     * Get all plaintiffs for submitter.
     */
    public function defendantsRepresentatives()
    {
        return $this->hasMany('App\Models\DefendantsRepresentative');
    }

    /**
     * Get all plaintiffs for submitter.
     */
    public function otherParties()
    {
        return $this->hasMany('App\Models\OtherParty');
    }

    /**
     * Get all documents for submitter.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
