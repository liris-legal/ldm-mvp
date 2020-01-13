<?php

namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;
use App\Models\Lawsuit;

class UpdateDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $submitter = Submitter::findOrFail($this->submitter_id);
        $typeDocument = TypeDocument::findOrFail($this->type_document_id);
        return ($submitter->description == 'plaintiff' || $submitter->description == 'defendant')
        && ($typeDocument->description == 'evidence') ? [
            'number' => 'bail|required|numeric',
            'name' => 'bail|required|max:150',
            'type_document_id' => 'bail|required|exists:type_documents,id',
            'submitter_id' => 'bail|required|exists:submitters,id',
            'lawsuit_id' => 'bail|required|exists:lawsuits,id',
            'created_at' => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ] : [
            'name' => 'bail|required|max:150',
            'type_document_id' => 'bail|required|exists:type_documents,id',
            'submitter_id' => 'bail|required|exists:submitters,id',
            'lawsuit_id' => 'bail|required|exists:lawsuits,id',
            'created_at' => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ];
    }
}
