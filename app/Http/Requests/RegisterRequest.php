<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|between:6,100',
        ];
            
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.string' => 'Name must be a string',
            'name.between' => 'Name must be between 2 and 100 characters',
            'email.required' => 'An email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must be less than 100 characters',
            'email.unique' => 'Email must be unique',
            'password.required' => 'A password is required',
            'password.string' => 'Password must be a string',
            'password.between' => 'Password must be between 6 and 100 characters',
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