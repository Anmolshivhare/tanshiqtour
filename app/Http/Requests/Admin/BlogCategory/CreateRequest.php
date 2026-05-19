<?php

namespace App\Http\Requests\Admin\BlogCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:150',
            'slug'        => 'nullable|string|max:200|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'status'      => 'nullable|exists:statuses,id',
        ];
    }
}
