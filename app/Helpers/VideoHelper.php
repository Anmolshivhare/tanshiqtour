<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Extract YouTube video ID and return embed URL
     *
     * @param  string|null  $url
     * @param  bool         $autoplay
     * @param  bool         $mute
     * @return string
     */
    public static function youtubeEmbed(?string $url, bool $autoplay = false, bool $mute = false): string
    {
        if (empty($url)) {
            return '';
        }

        if (
            preg_match(
                '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|v\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                $url,
                $matches
            )
        ) {
            $videoId = $matches[1];

            $params = [];
            if ($autoplay) $params[] = 'autoplay=1';
            if ($mute)     $params[] = 'mute=1';

            $query = $params ? '?' . implode('&', $params) : '';

            return "https://www.youtube.com/embed/{$videoId}{$query}";
        }

        return '';
    }
}
