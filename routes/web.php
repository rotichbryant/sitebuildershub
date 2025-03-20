<?php

use App\Http\Controllers\Landing\AboutUsController;
use App\Http\Controllers\Landing\ContactUsController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\PostingController as LandingPostingController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\PostingController as DashboardPostingController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Dashboard\StaffController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\SystemController;
use App\Http\Controllers\Landing\ProfileController as LandingProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::name('landing.')->group(function () {
    Route::get('/',          [HomeController::class, 'index'])->name('home');
    Route::get('/postings',  [LandingPostingController::class, 'index'])->name('postings');
    Route::get('/aboutus',   [AboutUsController::class, 'index'])->name('aboutus');
    Route::get('/contactus', [ContactUsController::class, 'index'])->name('contactus');
    
    Route::middleware('landing.auth')->group(function () {
        Route::get('/profile',      [LandingProfileController::class, 'index'])->name('profile');
        Route::put('/profile/edit', [LandingProfileController::class, 'index'])->name('profile.edit');
    });
});

Route::name('dashboard.')->prefix('dashboard')->group(function () {
    Route::middleware('admin.auth')->group(function () {
        Route::get('/',             [OverviewController::class, 'index'])->name('overview');
        Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications');
        Route::get('/company',      [CompanyController::class, 'index'])->name('company');
        Route::get('/clients',      [ClientsController::class, 'index'])->name('clients');
        Route::get('/subscriptions',[SubscriptionController::class, 'index'])->name('subscriptions');
        Route::get('/postings',     [DashboardPostingController::class, 'index'])->name('postings');
        Route::get('/staff',        [StaffController::class,    'index'])->name('staff');
        Route::get('/system',       [SystemController::class,   'index'])->name('system');
        Route::post('/system',      [SystemController::class,   'store'])->name('system.store');
        Route::get('/profile',      [DashboardProfileController::class,   'index'])->name('profile'); 
    });
});
require __DIR__.'/auth.php';
