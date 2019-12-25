<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeAuthor extends Model
{
    public $fillable = ['name'];

    /**
     * Get all plaintiffs for type Author.
     */
    public function plaintiffs()
    {
        return $this->hasMany('App\Models\Plaintiff', 'type_author_id');
    }

    /**
     * Get all plaintiffs for type Author.
     */
    public function plaintiffRepresentatives()
    {
        return $this->hasMany('App\Models\PlaintiffRepresentative', 'type_author_id');
    }

    /**
     * Get all plaintiffs for type Author.
     */
    public function defendants()
    {
        return $this->hasMany('App\Models\Defendant', 'type_author_id');
    }

    /**
     * Get all plaintiffs for type Author.
     */
    public function defendantsRepresentatives()
    {
        return $this->hasMany('App\Models\DefendantsRepresentative', 'type_author_id');
    }

    /**
     * Get all plaintiffs for type Author.
     */
    public function otherParty()
    {
        return $this->hasMany('App\Models\OtherParty', 'type_author_id');
    }
}
