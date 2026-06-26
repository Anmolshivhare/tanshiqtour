<?php

namespace App\Http\Requests\Admin\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'gallery_images' => 'nullable|array|max:20',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_file'     => 'nullable|file|mimes:mp4,mov|max:20480',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'    => 'nullable|boolean',
            'destination_id' => 'nullable|exists:destinations,id',
            'tour_id'        => 'nullable|exists:tours,id',
            'status'         => 'nullable|exists:statuses,id',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->hasFile('gallery_images') && !$this->hasFile('video_file')) {
                $validator->errors()->add('gallery_images', 'Upload at least one gallery image or a video.');
            }
        });
    }
}
