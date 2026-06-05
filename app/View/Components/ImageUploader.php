<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ImageUploader extends Component
{
    public string $name;
    public ?string $previewImage;
    public ?string $defaultImage;
    public bool $required;
    public string $id;
    public ?string $label;
    public string $accept;
    public float $maxSize;
    public array $allowedTypes;
    public bool $enableCrop;
    public ?float $cropAspectRatio;

    public function __construct(
        string $name = 'image',
        ?string $previewImage = null,
        ?string $defaultImage = null,
        bool $required = false,
        ?string $id = null,
        ?string $label = null,
        string $accept = 'image/jpeg,image/png,image/webp',
        float|int|string $maxSize = 2,
        array|string|null $allowedTypes = null,
        bool $enableCrop = true,
        float|int|string|null $cropAspectRatio = null
    ) {
        $this->name = $name;
        $this->previewImage = $previewImage;
        $this->defaultImage = $defaultImage;
        $this->required = $required;
        $this->id = $id ?: 'iu_' . Str::of($name)->replace(['[', ']'], '_')->slug('_');
        $this->label = $label ?: Str::of($name)->replace(['[', ']'], ' ')->replace('_', ' ')->headline();
        $this->accept = $accept;
        $this->maxSize = (float) $maxSize;
        $this->enableCrop = $enableCrop;
        $this->cropAspectRatio = $cropAspectRatio !== null && $cropAspectRatio !== ''
            ? (float) $cropAspectRatio
            : null;

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
        return view('components.image-uploader');
    }
}
