<?php

namespace App\Http\Requests\Admin\Destination;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:150',
            'slug'              => 'nullable|string|max:200|unique:destinations,slug',
            'country'           => 'nullable|string|max:100',
            'state'             => 'nullable|string|max:100',
            'city'              => 'nullable|string|max:100',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'is_featured'       => 'nullable|boolean',
            'featured_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'status'            => 'nullable|exists:statuses,id',
        ];
    }
}
