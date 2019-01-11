<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
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
            'project_id'=> 'required',
            'status_id'=> 'required',
            'priority_id'=> 'required',
            'wanted_end_datetime'=> 'required',
            'wanted_start_datetime'=> 'required',

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'subject.required' => 'The subject is required and must be 100 characters max.',
            'description.required'=> 'The description is required.',
            'project_id.required'=> 'The project is required.',
            'status_id.required'=> 'The status is required.',
            'priority_id.required'=> 'The priority is required.',
            'wanted_end_datetime.required'=> 'The wanted ending date is required.',
            'wanted_start_datetime.required'=> 'The active state is required.',

        ];
    }
}
