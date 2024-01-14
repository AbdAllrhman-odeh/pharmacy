<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addAdminRequest extends FormRequest
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
            'firstName'=>'required|min:3|max:20|string',
            'secondName'=>'required|min:3|max:20|string',
            'email'=>'required|min:3|max:30|unique:users',
            'password'=>'required|min:5|max:20|confirmed|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])/',
        ];
    }
}
