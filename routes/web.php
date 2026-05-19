<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Front\FrontAuthController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/tour-packages', [HomeController::class, 'tours'])->name('front.tours');
Route::get('/about-us', [HomeController::class, 'about'])->name('front.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('front.contact');

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
});
