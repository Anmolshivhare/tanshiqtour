<?php

namespace App\Http\Requests\Admin\Banner;

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
            'title'       => 'required|string|max:200',
            'subtitle'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'button_text'  => 'nullable|string|max:100',
            'button_url'   => 'nullable|url|max:255',
            'sort_order'   => 'nullable|integer|min:0',
            'status'       => 'nullable|exists:statuses,id',
        ];
    }
}
