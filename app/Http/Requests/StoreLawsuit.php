<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLawsuit extends FormRequest
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
        return [
            'type_lawsuit_id' => 'bail|required',
            'number' => 'bail|required|numeric',
            'name' => 'bail|required|between:1,150',
            'courts_departments' => 'bail|required|string:1,150',

            'plaintiffs' => 'bail|array|between:1,30',
            'plaintiffs.*' => 'bail|required|string|distinct|between:1,100',

            'plaintiff_representatives' => 'bail|array|between:1,30',
            'plaintiff_representatives.*' => 'bail|string|distinct|between:1,100',

            'defendants' => 'bail|array|between:1,30',
            'defendants.*' => 'bail|required|string|distinct|between:1,100',

            'defendant_representatives' => 'bail|array|between:1,30',
            'defendant_representatives.*' => 'bail|string|distinct|between:1,100',

            'other_parties' => 'bail|array|between:1,30',
            'other_parties.*' => 'bail|string|distinct|between:1,100',
        ];
    }
}
