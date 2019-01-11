<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'last_name'=> 'required|max:100',
            'first_name'=> 'required|max:100',
            'password'=> 'required|max:100',
            'email'=> 'email',
            'role_id'=> 'required',
            'is_active'=> 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'last_name.required' => 'The last name is required.',
            'first_name.required'=> 'The first name is required.',
            'password.required'=> 'The password is required.',
            'email.required'=> 'The email is required.',
            'role_id.required' => 'The user role is required',
            'is_active.required'=> 'The active state is required.'
        ];
    }
}
