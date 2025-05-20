<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ChildSubCategoryController;
use App\Http\Controllers\Landing\AboutUsController;
use App\Http\Controllers\Landing\ContactUsController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\PostingController as LandingPostingController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\OverviewController as DashboardOverviewController;
use App\Http\Controllers\Landing\OverviewController as LandingOverviewController;
use App\Http\Controllers\Dashboard\PostingController as DashboardPostingController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Dashboard\StaffController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\SystemController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\GoogleMapsController;
use App\Http\Controllers\Landing\ChatController;
use App\Http\Controllers\Landing\DashboardController;
use App\Http\Controllers\Landing\MyPostingsController;
use App\Http\Controllers\Landing\ProfileController as LandingProfileController;
use App\Models\TransactionModel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::name('landing.')->group(function () {
    Route::get('/',                        [HomeController::class, 'index'])->name('home');
    Route::get('/postings/view',           [LandingPostingController::class, 'show'])->name('postings.view');
    Route::get('/postings',                [LandingPostingController::class, 'index'])->name('postings');
    Route::get('/aboutus',                 [AboutUsController::class, 'index'])->name('aboutus');
    Route::get('/contactus',               [ContactUsController::class, 'index'])->name('contactus');
    Route::get('/places',                  [GoogleMapsController::class, 'create'])->name('maps.places');
    
    Route::middleware('landing.auth')->group(function () {
        Route::get('/overview',                [LandingOverviewController::class, 'index'])->name('overview');
        Route::get('/mypostings',              [MyPostingsController::class, 'index'])->name('mypostings');
        Route::get('/mypostings/create',       [MyPostingsController::class, 'create'])->name('mypostings.create');
        Route::post('/mypostings/upload',      [MyPostingsController::class, 'upload'])->name('mypostings.upload');
        Route::post('/mypostings',             [MyPostingsController::class, 'store'])->name('mypostings.store');
        Route::get('/chat',                    [ChatController::class, 'index'])->name('chat');
        Route::get('/profile/{tab}',           [LandingProfileController::class, 'create'])->name('profile');
        Route::post('/profile/business/store', [LandingProfileController::class, 'business_store'])->name('profile.business.store');
        Route::post('/profile/business',       [LandingProfileController::class, 'business'])->name('profile.business');
        Route::post('/profile/personal',       [LandingProfileController::class, 'personal'])->name('profile.personal');
        // Route::put('/profile/edit', [LandingProfileController::class, 'index'])->name('profile.edit');
    });
});

Route::name('dashboard.')->prefix('dashboard')->group(function () {
    Route::middleware('admin.auth')->group(function () {
        Route::get('/',                             [DashboardOverviewController::class, 'index'])->name('overview');
        Route::get('/notifications',                [NotificationController::class, 'index'])->name('notifications');
        Route::get('/company',                      [CompanyController::class, 'index'])->name('company');
        Route::get('/clients',                      [ClientsController::class, 'index'])->name('clients');

        Route::get('/subscriptions',                          [SubscriptionController::class, 'index'])->name('subscriptions');
        Route::put('/subscriptions/{subscription}/show',      [SubscriptionController::class, 'show'])->name('subscriptions.edit');
        Route::post('/subscriptions/{subscription}/update',   [SubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::post('/subscriptions',                         [SubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::delete('/subscriptions/{subscription}/delete', [SubscriptionController::class, 'destroy'])->name('subscriptions.delete');
        
        Route::get('/transactions',                 [TransactionController::class, 'index'])->name('transactions');

        Route::get('/categories/fetch',                     [CategoryController::class, 'create'])->name('categories.fetch');
        Route::get('/categories',                           [CategoryController::class, 'index'])->name('categories');
        Route::post('/categories',                          [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{category}/delete',      [CategoryController::class, 'destroy'])->name('categories.delete');

        Route::get('/subcategories',                          [SubCategoryController::class, 'index'])->name('sub_categories');
        Route::get('/categories/fetch',                       [SubCategoryController::class, 'create'])->name('sub_categories.fetch');
        Route::post('/subcategories',                         [SubCategoryController::class, 'store'])->name('sub_categories.store');
        Route::delete('/subcategories/{sub_category}/delete', [SubCategoryController::class, 'destroy'])->name('sub_categories.delete');

        Route::get('/childsubcategories',                            [ChildSubCategoryController::class, 'index'])->name('child_sub_categories');
        Route::post('/childsubcategories',                           [ChildSubCategoryController::class, 'store'])->name('child_sub_categories.store');
        Route::post('/childsubcategories/{childsubcategory}/delete', [ChildSubCategoryController::class, 'destroy'])->name('child_sub_categories.destroy');
       
        Route::get('/postings/{posting}', [DashboardPostingController::class, 'show'])->name('postings.show');
        Route::get('/postings',           [DashboardPostingController::class, 'index'])->name('postings');

        Route::get('/staff',                 [StaffController::class,    'index'])->name('staff');
        Route::get('/system',                [SystemController::class,   'index'])->name('system');
        Route::post('/system',               [SystemController::class,   'store'])->name('system.store');
        Route::get('/profile',               [DashboardProfileController::class,   'index'])->name('profile'); 
    });
});
require __DIR__.'/auth.php';
