<?php

namespace App\Http\Requests\Admin\Tour;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:200',
            'slug'             => 'nullable|string|max:250|unique:tours,slug',
            'location'         => 'nullable|string|max:150',
            'duration'         => 'nullable|string|max:100',
            'price_per_person' => 'nullable|numeric|min:0',
            'description'      => 'nullable|string',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gallery_images'   => 'nullable|array|max:10',
            'is_featured'       => 'nullable|boolean',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'destination_id'   => 'nullable|exists:destinations,id',
            'max_persons'      => 'nullable|integer|min:1',
            'status'           => 'nullable|exists:statuses,id',
        ];
    }
}
