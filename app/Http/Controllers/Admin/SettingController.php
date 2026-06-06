<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SettingRepository;
use App\Helpers\UserHelper;
use Exception;

class SettingController extends WebController
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->indexRouteName    = 'admin.settings.index';
        $this->middleware(['permission:setting-list'], ['only' => ['index']]);
        $this->middleware(['permission:setting-edit'], ['only' => ['update']]);
    }

    public function index()
    {
        $settings = $this->settingRepository->getAsKeyValue();
        return view('admin.setting.index', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            // Handle file uploads
            foreach ($data as $key => $value) {
                if ($request->hasFile($key)) {
                    $path = UserHelper::uploadImage($request->file($key), config('constants.setting_image_path'));
                    $data[$key] = basename($path);
                }
            }
            $this->settingRepository->saveSettings($data);
            return $this->successResponse($this->indexRouteName, 'Settings updated successfully.');
        } catch (Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
