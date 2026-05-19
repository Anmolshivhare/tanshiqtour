<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FrontProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'required|digits:10',
            'address' => 'nullable|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cropped_image' => 'nullable|string', // Base64 cropped image data
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Please enter your phone number.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'profile_pic.image' => 'Please upload a valid image file.',
            'profile_pic.mimes' => 'Allowed image formats: jpeg, png, jpg, webp.',
            'profile_pic.max' => 'Image size cannot exceed 2MB.',
            'cropped_image.string' => 'Invalid image data format.',
        ];
    }
}
