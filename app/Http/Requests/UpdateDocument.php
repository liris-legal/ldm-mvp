<?php

namespace App\Http\Requests;

use Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;
use Illuminate\Validation\Rule;

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
        $rules = [
            'name' => 'bail|required|max:150',
            'type_document_id' => 'bail|required|exists:type_documents,id',
            'submitter_id' => 'bail|required|exists:submitters,id',
            'lawsuit_id' => 'bail|required|exists:lawsuits,id',
            'created_at' => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ];

        // update request
        if (isset($this->document) && ($this->document->submitter_id == 1 || $this->document->submitter_id == 3)
            && ($this->document->type_document_id == 2)) {
            $rules['number'] = 'bail|required|numeric|unique:documents,number,'
                . $this->document->id . ',id,lawsuit_id,' . $this->document->lawsuit_id
                . ',submitter_id,' . $this->document->submitter_id . ',name,' . $this->document->name;
        } else {
            // create request
            $rules['file'] = 'bail|required|mimes:pdf,doc,docx|max:204800';
        }

        return $rules;
    }
}
