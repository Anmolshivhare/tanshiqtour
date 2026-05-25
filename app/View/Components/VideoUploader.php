<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class VideoUploader extends Component
{
    public string $name;
    public ?string $previewVideo;
    public ?string $requiredType;
    public bool $required;
    public string $id;
    public ?string $label;
    public string $accept;
    public float $maxSize;
    public array $allowedTypes;

    public function __construct(
        string $name = 'video',
        ?string $previewVideo = null,
        ?string $requiredType = null,
        bool $required = false,
        ?string $id = null,
        ?string $label = null,
        string $accept = 'video/mp4,video/quicktime,image/jpeg,image/png,image/jpg,image/webp',
        float|int|string $maxSize = 20,
        array|string|null $allowedTypes = null
    ) {
        $this->name = $name;
        $this->previewVideo = $previewVideo;
        $this->requiredType = $requiredType;
        $this->required = $required;
        $this->id = $id ?: 'vu_' . Str::of($name)->replace(['[', ']'], '_')->slug('_');
        $this->label = $label ?: Str::of($name)->replace(['[', ']'], ' ')->replace('_', ' ')->headline();
        $this->accept = $accept;
        $this->maxSize = (float) $maxSize;

        if (is_string($allowedTypes) && $allowedTypes !== '') {
            $allowedTypes = array_map('trim', explode(',', $allowedTypes));
        }

        $allowed = is_array($allowedTypes) && !empty($allowedTypes)
            ? $allowedTypes
            : ['mp4', 'mov', 'jpg', 'jpeg', 'png', 'webp'];

        $this->allowedTypes = array_values(array_filter(array_map(
            static fn($type) => strtolower((string) $type),
            $allowed
        )));
    }

    public function render(): View|Closure|string
    {
        return view('components.video-uploader');
    }
}

