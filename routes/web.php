<?php

use App\Http\Controllers\AlertsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SystemController;
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

Route::middleware('auth')->group(function () {
    Route::get('/',             [OverviewController::class, 'index'])->name('overview');
    Route::get('/alerts',       [AlertsController::class, 'index'])->name('alerts');
    Route::get('/appointments', [AppointmentsController::class, 'index'])->name('appointments');
    Route::get('/company',      [CompanyController::class, 'index'])->name('company');
    Route::get('/calendar',     [CalendarController::class, 'index'])->name('calendar');
    Route::get('/clients',      [ClientsController::class, 'index'])->name('clients');

    // Mail Controller Routes
    Route::get('/mail',          [MailController::class, 'index'])->name('mail');
    Route::post('/mail',         [MailController::class, 'store'])->name('mail.store');
    Route::post('/mail/{account}',[MailController::class, 'show'])->name('mail.show');
    // Mail Controller Routes

    Route::get('/staff',        [StaffController::class, 'index'])->name('staff');
    Route::get('/system',       [SystemController::class, 'index'])->name('system');
    Route::get('/services',     [ServicesController::class, 'index'])->name('services');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
