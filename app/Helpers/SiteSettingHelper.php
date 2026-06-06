<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Vite;

class SiteSettingHelper
{
    private static ?array $cachedValues = null;
    private static ?Setting $cachedBag = null;

    /**
     * Default values used when a setting is missing or blank.
     */
    public static function defaults(): array
    {
        return [
            'company_name' => 'Tanishq Tour & Travel',
            'contact_email' => 'info@tanishqtourandtravels.com',
            'contact_phone' => '+91-8445542594',
            'copyright' => 'Copyright 2026 Tanishq Tour',
            'address' => '220, Udyog Vihar Phase 4, Gurugram, Haryana',
            'facebook_url' => 'https://www.facebook.com/profile.php?id=61584292436038',
            'instagram_url' => 'https://www.instagram.com/tanishqtourandtravels/',
            'twitter_url' => 'https://x.com/',
            'youtube_url' => 'https://www.youtube.com/',
            'whatsapp_number' => '918445542594',
            'website_url' => 'https://tanishqtourandtravels.com',
            'support_email' => 'support@tanishqtourandtravels.com',
            'google_play_url' => '',
            'app_store_url' => '',
            'live_streaming_url' => '',
            'footer_copyright_text' => 'Copyright 2026 Tanishq Tour',
            'header_logo' => '',
            'footer_logo' => '',
            'favicon' => '',
            'sidebar_logo_img' => '',
            'header_banner_img' => '',
        ];
    }

    /**
     * Return the current settings merged with defaults.
     */
    public static function values(): array
    {
        if (self::$cachedValues !== null) {
            return self::$cachedValues;
        }

        $values = self::defaults();

        foreach (Setting::query()->pluck('value', 'key')->all() as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
            }

            if ($value === null || $value === '') {
                continue;
            }

            $values[$key] = $value;
        }

        return self::$cachedValues = $values;
    }

    /**
     * Build a Setting model instance that can be read as both an object and array.
     */
    public static function bag(): Setting
    {
        if (self::$cachedBag !== null) {
            return self::$cachedBag;
        }

        $setting = new Setting();
        $setting->forceFill(self::values());

        return self::$cachedBag = $setting;
    }

    /**
     * Resolve a setting value with a fallback.
     */
    public static function value(string $key, mixed $default = ''): mixed
    {
        $values = self::values();
        $value = $values[$key] ?? $default;

        return is_string($value) ? trim($value) : $value;
    }

    /**
     * Resolve a setting image URL with a fallback asset.
     */
    public static function imageUrl(string $key, string $defaultAsset): string
    {
        $value = trim((string) self::value($key, ''));

        if ($value !== '') {
            return asset('storage/' . config('constants.setting_image_path') . '/' . $value);
        }

        return Vite::asset($defaultAsset);
    }
}
