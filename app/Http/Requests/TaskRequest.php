<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
                'title' => 'required|string|between:2,100',
                'description' => 'required|string|between:2,100',
                'due_date' => 'required|date',
                'status_id' => 'required|exists:task_statuses,id',
            ];
        }else{
            return [
                'title' => 'string|between:2,100',
                'description' => 'string|between:2,100',
                'due_date' => 'date',
                'status_id' => 'exists:task_statuses,id',
                
            ];
        }
        
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.between' => 'The title must be between 2 and 100 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.between' => 'The description must be between 2 and 100 characters.',
            'due_date.required' => 'The due date field is required.',
            'due_date.date' => 'The due date must be a date.',
            'status_id.required' => 'The status field is required.',
            'status_id.exists' => 'The status must be a valid status.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'errors' => $errors,
            'message' => 'The given data was invalid.',
        ], 422));
    }
    
    
}