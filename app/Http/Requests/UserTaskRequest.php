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
        return false;
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
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'remarks' => 'required|string|between:2,100',
                'status_id' => 'required|exists:taskStatus,id',
            ];
        }else{
            return [
                'title' => 'string|between:2,100',
                'description' => 'string|between:2,100',
                'due_date' => 'date',
                'start_date' => 'date',
                'end_date' => 'date',
                'remarks' => 'string|between:2,100',
                'status_id' => 'exists:taskStatus,id',
                
            ];
        }
        
        
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.string' => 'Title must be a string',
            'title.between' => 'Title must be between 2 and 100 characters',
            'description.required' => 'A description is required',
            'description.string' => 'Description must be a string',
            'description.between' => 'Description must be between 2 and 100 characters',
            'due_date.required' => 'A due date is required',
            'due_date.date' => 'Due date must be a valid date',
            'start_date.required' => 'A start date is required',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.required' => 'An end date is required',
            'end_date.date' => 'End date must be a valid date',
            'remarks.required' => 'A remarks is required',
            'remarks.string' => 'Remarks must be a string',
            'remarks.between' => 'Remarks must be between 2 and 100 characters',
            'status_id.required' => 'A status is required',
            'status_id.exists' => 'Status must be a valid status',
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