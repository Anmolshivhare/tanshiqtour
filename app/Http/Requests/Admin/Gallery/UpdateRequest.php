<?php

namespace App\Http\Requests\Admin\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'gallery_images' => 'nullable|array|max:20',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_gallery_image_ids'   => 'nullable|array',
            'remove_gallery_image_ids.*' => 'integer|exists:gallery_images,id',
            'video_file'     => 'nullable|file|mimes:mp4,mov|max:20480',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured'    => 'nullable|boolean',
            'destination_id' => 'nullable|exists:destinations,id',
            'tour_id'        => 'nullable|exists:tours,id',
            'status'         => 'nullable|exists:statuses,id',
        ];
    }
}
