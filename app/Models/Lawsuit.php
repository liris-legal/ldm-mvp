<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lawsuit extends Model
{
    public $fillable = ['type_case_id', 'number', 'name', 'courts_departments'];
    public $timestamps = true;

    /**
     * Get the type lawsuits for the lawsuit.
     */
    public function typeLawsuit()
    {
        return $this->belongsTo('App\Models\TypeLawsuit', 'type_lawsuit_id');
    }

    /**
     * Get all defendants for Cases.
     */
    public function defendants()
    {
        return $this->hasMany('App\Models\Defendant');
    }

    /**
     * Get all defendant representatives for Cases.
     */
    public function defendantRepresentatives()
    {
        return $this->hasMany('App\Models\DefendantRepresentative');
    }

    /**
     * Get all plaintiffs for Cases.
     */
    public function plaintiffs()
    {
        return $this->hasMany('App\Models\Plaintiff');
    }

    /**
     * Get all plaintiffs representatives for Cases.
     */
    public function plaintiffRepresentatives()
    {
        return $this->hasMany('App\Models\PlaintiffRepresentative');
    }

    /**
     * Get all other parties for Cases.
     */
    public function otherParties()
    {
        return $this->hasMany('App\Models\OtherParty');
    }
}
