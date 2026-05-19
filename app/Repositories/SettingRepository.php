<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all settings grouped by their group key.
     */
    public function getAllGrouped(): array
    {
        return $this->model->get()->groupBy('group')->toArray();
    }

    /**
     * Get settings as a simple key => value array.
     */
    public function getAsKeyValue(): array
    {
        return $this->model->pluck('value', 'key')->toArray();
    }

    /**
     * Get a setting value by key.
     */
    public function getByKey(string $key, $default = null)
    {
        $setting = $this->model->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Save multiple settings at once from a request array.
     */
    public function saveSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->model->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    /**
     * Get data from request.
     */
    public function getDataFromRequest($request): array
    {
        return $request->except(['_token', '_method']);
    }
}
