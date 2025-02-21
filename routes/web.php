<?php

use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\PostingController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Dashboard\StaffController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\SystemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Overview');
// })->middleware(['auth', 'verified'])->name('overview');

Route::middleware('auth')->name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('/',             [OverviewController::class, 'index'])->name('overview');
    Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications');
    Route::get('/company',      [CompanyController::class, 'index'])->name('company');
    Route::get('/clients',      [ClientsController::class, 'index'])->name('clients');
    Route::get('/subscriptions',[SubscriptionController::class, 'index'])->name('subscriptions');
    Route::get('/postings',     [PostingController::class, 'index'])->name('postings');
    Route::get('/staff',        [StaffController::class,    'index'])->name('staff');
    Route::get('/system',       [SystemController::class,   'index'])->name('system');
    Route::get('/profile',      [DashboardProfileController::class,   'index'])->name('profile');
    // Route::get('/profile',      [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile',    [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile',   [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
