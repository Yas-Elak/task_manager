<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketFormRequest extends FormRequest
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
            'project_id'=> 'required_without:task_id',
            'task_id'=> 'required_without:project_id',
            'agent_id' => 'required',
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
            'project_id.required'=> 'The project or the task is required.',
            'task_id.required'=> 'The task or the project is required.',
            'agent_id.required' => 'The ticket need an agent.',
            'status_id.required'=> 'The status is required.',
            'priority_id.required'=> 'The priority is required.',
            'is_active.required'=> 'The active state is required.',
        ];
    }
}
