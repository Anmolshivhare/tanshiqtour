<?php

namespace App\Http\Requests\Admin\User;

use App\Helpers\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email,' . $this->user,
            'phone_no'     => 'required|digits_between:10,12|unique:users,phone_no,' . $this->user,
            'profile_pic' => 'image|mimes:jpeg,png,jpg|nullable',
            'role'      => 'required|exists:roles,id',
            'status'      => ValidationHelper::idExistsValidationRule('statuses'),
            'date_of_birth' => 'nullable|date|before:today'
        ];
    }
}
