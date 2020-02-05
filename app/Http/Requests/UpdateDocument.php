<?php

namespace App\Http\Requests;

use App\Http\Controllers\Helpers;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;
use App\Models\Lawsuit;
use Illuminate\Support\Facades\Validator;

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
            'name'              => 'bail|required|max:150',
            'number'            => 'bail|max:100|min:1|nullable',
            'subnumber'         => 'bail|max:50|min:1|nullable',
            'type_document_id'  => 'bail|required|exists:type_documents,id',
            'submitter_id'      => 'bail|required',
            'lawsuit_id'        => 'bail|required|exists:lawsuits,id',
            'created_at'        => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ];

        if (($this->submitter_id == 1 || $this->submitter_id == 3) && ($this->type_document_id == 2)) {
            $rules['number'] = 'bail|required|numeric|unique:documents,number,' . $this->document->id . ',id'
                . ',lawsuit_id,' . $this->document->lawsuit_id . ',submitter_id,' . $this->submitter_id
                . ',name,' . $this->name . ',subnumber,' . $this->subnumber;

            // validate unique number, subnumber
            Helpers::validatedUnique($this);

            // validate exist number, subnumber
            Helpers::validatedExists($this);
        }

        return $rules;
    }
}
