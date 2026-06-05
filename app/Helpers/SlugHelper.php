<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SlugHelper
{
    /**
     * function to create slug from text
     *
     * @param string $text
     * @return string
     */
    public static function make(string $text): string
    {
        return Str::slug($text);
    }
}
