<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:5'
        ];
    }

    /**
     * messages is validations
     */
    public function messages()
    {
        return [
            'email.require'   =>  'Email is required!',
            'email.email'   =>  'Email is invalid!',
            'password.require'   =>  'Password is required!',
            'password.min'   =>  'Password is too short!',
        ];
    }

}
