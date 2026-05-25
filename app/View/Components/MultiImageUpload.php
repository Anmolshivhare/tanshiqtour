<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MultiImageUpload extends Component
{
    public string $name;
    public string $id;
    public ?string $label;
    public bool $required;
    public string $accept;
    public float $maxSize;
    public int $maxFiles;
    public array $allowedTypes;
    public ?string $defaultImage;

    public function __construct(
        string $name = 'gallery_images[]',
        ?string $id = null,
        ?string $label = null,
        bool $required = false,
        string $accept = 'image/jpeg,image/png,image/webp',
        float|int|string $maxSize = 2,
        int|string $maxFiles = 10,
        array|string|null $allowedTypes = null,
        ?string $defaultImage = null
    ) {
        $this->name = $name;
        $this->id = $id ?: 'miu_' . Str::of($name)->replace(['[', ']'], '_')->slug('_');
        $this->label = $label ?: Str::of($name)->replace(['[', ']'], ' ')->replace('_', ' ')->headline();
        $this->required = $required;
        $this->accept = $accept;
        $this->maxSize = (float) $maxSize;
        $this->maxFiles = (int) $maxFiles;
        $this->defaultImage = $defaultImage;

        if (is_string($allowedTypes) && $allowedTypes !== '') {
            $allowedTypes = array_map('trim', explode(',', $allowedTypes));
        }

        $allowed = is_array($allowedTypes) && !empty($allowedTypes)
            ? $allowedTypes
            : ['jpg', 'jpeg', 'png', 'webp'];

        $this->allowedTypes = array_values(array_filter(array_map(
            static fn($type) => strtolower((string) $type),
            $allowed
        )));
    }

    public function render(): View|Closure|string
    {
        return view('components.multi-image-upload');
    }
}
