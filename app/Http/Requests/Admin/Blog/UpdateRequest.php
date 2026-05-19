<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:250',
            'slug'          => 'nullable|string|max:300|unique:blogs,slug,' . $this->route('blog'),
            'author_id'     => 'nullable|exists:authors,id',
            'category_id'   => 'nullable|exists:blog_categories,id',
            'excerpt'       => 'nullable|string|max:600',
            'body'          => 'required|string',
            'featured_image'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags'          => 'nullable|string',
            'is_featured'   => 'nullable|boolean',
            'status'        => 'nullable|exists:statuses,id',
            'published_at'  => 'nullable|date',
        ];
    }
}
