<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::firstOrCreate([
            'name' => config('constants.active_status_name'),
            'module' => config('constants.common_status_name'),
        ]);

        Status::firstOrCreate([
            'name' => config('constants.inactive_status_name'),
            'module' => config('constants.common_status_name'),
        ]);
    }
}
