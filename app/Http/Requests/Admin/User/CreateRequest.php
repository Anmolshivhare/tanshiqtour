<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name'      => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
            'phone_no'  => 'required|digits_between:10,12|unique:users,phone_no',
            'profile_pic' => 'image|mimes:jpeg,png,jpg|nullable',
            'role'      => 'required|exists:roles,id',
            'date_of_birth' => 'nullable|date|before:today'
        ];
    }
}
