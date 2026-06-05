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
            'type'           => 'required|in:image,video',
            'file_path'      => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:20480',
            'thumbnail_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order'     => 'nullable|integer|min:0',
            'is_featured'    => 'nullable|boolean',
            'destination_id' => 'nullable|exists:destinations,id',
            'tour_id'        => 'nullable|exists:tours,id',
            'status'         => 'nullable|exists:statuses,id',
        ];
    }
}
