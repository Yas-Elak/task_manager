<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordFormRequest extends FormRequest
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
            'current_password' => ['required'],
            'password' => ['required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@?#\$%\^&\*])(?=.{8,})/',
                'confirmed'],
            'password_confirmation' => ['required'],



        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'current_password.required' => 'The Current password is required.',
            'password.required'=> 'The password must be of 8 char min, with 1 lowercase, 1 uppercase and 1 symbol.',
            'password.regex'=> 'The password must be of 8 char min, with 1 lowercase, 1 uppercase and 1 symbol.',
            'password_confirmation.required' => 'The confirmation is required.',

        ];
    }
}
