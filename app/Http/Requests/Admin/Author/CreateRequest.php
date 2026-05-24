<?php

namespace App\Http\Requests\Admin\Author;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:150',
            'email'         => 'nullable|email|max:150|unique:authors,email',
            'bio'           => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status'        => 'nullable|exists:statuses,id',
        ];
    }
}
