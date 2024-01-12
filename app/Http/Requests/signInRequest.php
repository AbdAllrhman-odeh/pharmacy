<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class signInRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email|min:5|max:30',
            'password'=>'required|string|min:5|max:20',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.min' => 'The email must be at least 5 characters.',
            'email.max' => 'The email may not be greater than 30 characters.',
            'password.required' => 'The password field is required.',
            'password.string' => 'Please enter a valid password.',
            'password.min' => 'The password must be at least 5 characters.',
            'password.max' => 'The password may not be greater than 20 characters.',
        ];
    }
}
