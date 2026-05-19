<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Function to get all the role from the request
     *
     * @param object $request
     * @return array
     */
    public function getDataFromRequest($request)
    {
        return $request->only([
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'twitter_url',
            'sidebar_logo_img',
            'header_logo_img',
            'admin_panel_logo_img',
            'header_banner_img',
            'google_play_url',
            'app_store_url',
            'live_streaming_url',
            'footer_copyright_text',
            'company_name',
        ]);
    }
}
