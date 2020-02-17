<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRecently extends Model
{
    protected $fillable = ['user_id', 'document_id', 'lawsuit_id', 'type_document_id',
        'name', 'subnumber', 'number', 'created_at'];
}
