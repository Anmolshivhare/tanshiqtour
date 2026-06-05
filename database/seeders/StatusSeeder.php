<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder only handles the COMMON active/inactive statuses used by modules
     * like Destinations, Tours, Gallery, Blog, Authors, BlogCategories, etc.
     *
     * Module-specific statuses (Review, Enquiry, Booking) are handled as
     * PHP backed enums:
     *   - App\Enums\ReviewStatus  → pending | approved | rejected
     *   - App\Enums\EnquiryStatus → new | read | replied | closed
     *   - App\Enums\BookingStatus → pending | confirmed | cancelled
     */
    public function run(): void
    {
        Status::firstOrCreate([
            'name'   => config('constants.active_status_name'),
            'module' => config('constants.common_status_name'),
        ]);

        Status::firstOrCreate([
            'name'   => config('constants.inactive_status_name'),
            'module' => config('constants.common_status_name'),
        ]);
    }
}
