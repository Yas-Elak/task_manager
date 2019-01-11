<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
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
            'subject'=> 'required|max:100',
            'description'=> 'required',
            'manager_id'=> 'required',
            'status_id'=> 'required',
            'priority_id'=> 'required',
            'is_active'=> 'required',

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'subject.required' => 'The subject is required and must be 100 characters max.',
            'description.required'=> 'The description is required.',
            'manager.required'=> 'The project manager required.',
            'status_id.required'=> 'The status is required.',
            'priority_id.required'=> 'The priority is required.',
            'is_active.required'=> 'The wanted starting date is required.',

        ];
    }
}
