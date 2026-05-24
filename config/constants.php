<?php

return [
    'success_response' => 'success',
    'super_admin_role_name' => 'super admin',
    'admin_role_name' => 'Admin',
    'customer_role_name' => 'Customer',
    'active_status_name' => 'Active',
    'inactive_status_name' => 'Inactive',
    'draft_status_name' => 'Draft',
    'publish_status_name' => 'Publish',
    'common_status_name' => 'common',
    'category_name' => 'Live News',
    'category_slug_name' => 'live-news',
    'category_status_name' => 'category',
    'setting_image_path' => 'setting_images',
    'category_image_path' => 'category_images',
    'news_post_image_path' => 'news_post_images',
    'company_name' => 'G9News',
    'active_status_value' => '1',
    'in_active_status_value' => '2',
    'inactive_status_value' => '2',
    'publish_status_value' => '3',
    'draft_status_value' => '4',
    'date_format' => 'd-m-Y',
    'guard_name' => 'web',
    'active_inactive_status_array' => [
        [
            'id' => 1,
            'label' => 'Active'
        ],
        [
            'id' => 0,
            'label' => 'Inactive'
        ],
    ],
    'company_logo' => 'resources/images/admin_logo.png', 
    'default_image' => 'resources/images/user-avtar.svg',

    // Tour configuration
    'tour_image_path' => 'tour_images',

    // Status module names
    'booking_status_name' => 'booking',
    'payment_status_name' => 'payment',

    // Booking status names
    'booking_pending_status' => 'Pending',
    'booking_paid_status' => 'Paid',
    'booking_cancelled_status' => 'Cancelled',
    'booking_failed_status' => 'Failed',

    // Payment status names
    'payment_initiated_status' => 'Initiated',
    'payment_success_status' => 'Success',
    'payment_failed_status' => 'Failed',
];
