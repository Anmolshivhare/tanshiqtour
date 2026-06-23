<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Front\FrontAuthController;
use App\Http\Controllers\Front\HomeController;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/home', '/', 301)->name('front.home');
Route::get('/tour-packages', [HomeController::class, 'tours'])->name('front.tours');
Route::get('/tours/{slug}', [HomeController::class, 'tourDetails'])->name('front.tour-details');
Route::post('/tours/{slug}/enquiry', [HomeController::class, 'storeTourEnquiry'])->name('front.tour.enquiry.store');
Route::post('/tours/{slug}/reviews', [HomeController::class, 'storeReview'])->name('front.tour.review.store');
Route::get('/about-us', [HomeController::class, 'about'])->name('front.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('front.contact');
Route::post('/contact-us', [HomeController::class, 'storeContact'])->name('front.contact.store');
Route::get('/destinations', [HomeController::class, 'destinations'])->name('front.destinations');
Route::get('/destinations/{slug}', [HomeController::class, 'destinationDetails'])->name('front.destination-details');
Route::get('/careers', [HomeController::class, 'careers'])->name('front.careers');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))->setPriority(1.0))
        ->add(Url::create(route('front.about'))->setPriority(0.8))
        ->add(Url::create(route('front.contact'))->setPriority(0.8))
        ->add(Url::create(route('front.destinations'))->setPriority(0.9))
        ->add(Url::create(route('front.tours'))->setPriority(0.9))
        ->add(Url::create(route('front.careers'))->setPriority(0.4));

    Destination::query()->whereNull('deleted_at')->get()->each(function ($destination) use ($sitemap) {
        $sitemap->add(
            Url::create(route('front.destination-details', $destination->slug))
                ->setLastModificationDate($destination->updated_at)
                ->setPriority(0.8)
        );
    });

    Tour::query()->whereNull('deleted_at')->get()->each(function ($tour) use ($sitemap) {
        $sitemap->add(
            Url::create(route('front.tour-details', $tour->slug))
                ->setLastModificationDate($tour->updated_at)
                ->setPriority(0.8)
        );
    });

    return response($sitemap->render(), 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Frontend Authentication Routes
Route::get('/login', [FrontAuthController::class, 'showLogin'])->name('front.login');
Route::post('/login', [FrontAuthController::class, 'login'])->name('front.post-login');
Route::get('/register', [FrontAuthController::class, 'showRegister'])->name('front.register');
Route::post('/register', [FrontAuthController::class, 'register'])->name('front.post-register');
Route::get('/profile', [FrontAuthController::class, 'showProfile'])->name('front.profile')->middleware('auth');
Route::post('/profile', [FrontAuthController::class, 'updateProfile'])->name('front.profile.update')->middleware('auth');
Route::get('/logout', [FrontAuthController::class, 'logout'])->name('front.logout');

// Admin auth
Route::get('/admin', function () {
    return redirect()->route('admin.login');
})->name('admin.root');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('admin.root');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post-login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin forgot/reset password routes (Laravel auth UI)
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Admin protected routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dashboard', DashboardController::class)->only(['index']);

    Route::get('/profile', [AuthController::class, 'editProfile'])->name('edit-user-profile');
    Route::post('/profile/update/{id}', [AuthController::class, 'updateProfile'])->name('update.user-profile');
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password/update', [AuthController::class, 'updatePassword'])->name('update-password');

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Destinations
    Route::resource('destinations', DestinationController::class);

    // Tour Packages
    Route::resource('tours', TourController::class);

    // Reviews
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/reviews/{id}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
    Route::get('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

    // Gallery
    Route::resource('galleries', GalleryController::class)->except(['show']);

    // Blog Categories
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show']);

    // Authors
    Route::resource('authors', AuthorController::class);

    //Banners
    Route::resource('banners', BannerController::class);

    // Blog Posts
    Route::resource('blogs', BlogController::class);

    // Enquiries
    Route::resource('enquiries', EnquiryController::class)->only(['index', 'show', 'destroy']);
    Route::get('/enquiries/{id}/reply', [EnquiryController::class, 'reply'])->name('enquiries.reply');
});

// Frontend Wishlist (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [\App\Http\Controllers\Front\WishlistController::class, 'index'])->name('front.wishlist');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Front\WishlistController::class, 'toggle'])->name('front.wishlist.toggle');
});

Route::redirect('/generate-sitemap', '/sitemap.xml', 301);
