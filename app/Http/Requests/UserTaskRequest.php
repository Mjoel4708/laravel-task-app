<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if ($this->method() === 'POST') {
            return [
                'task_id' => 'required|exists:tasks,id',
                'due_date' => 'required|date',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'remarks' => 'string|between:2,100',
                'status_id' => 'required|exists:task_statuses,id',
            ];
        }else{
            return [
                'task_id' => 'exists:tasks,id',
                'due_date' => 'date',
                'start_date' => 'date',
                'end_date' => 'date',
                'remarks' => 'string|between:2,100',
                'status_id' => 'exists:task_statuses,id',
            ];
        }
        
        
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'The task field is required.',
            'task_id.exists' => 'The task must be a valid task.',
            'due_date.required' => 'The due date field is required.',
            'due_date.date' => 'The due date must be a date.',
            'start_date.required' => 'The start date field is required.',
            'start_date.date' => 'The start date must be a date.',
            'end_date.required' => 'The end date field is required.',
            'end_date.date' => 'The end date must be a date.',
            'remarks.string' => 'The remarks must be a string.',
            'remarks.between' => 'The remarks must be between 2 and 100 characters.',
            'status_id.required' => 'The status field is required.',
            'status_id.exists' => 'The status must be a valid status.',
        ];
    }
    
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'errors' => $errors,
            'message' => 'The given data was invalid.',
        ], 422));
    }

}