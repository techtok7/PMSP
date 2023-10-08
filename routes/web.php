<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Authentication\VerificationController;
use App\Http\Controllers\Authentication\ForgotPasswordController;
use App\Http\Controllers\Authentication\SocialController;
use App\Http\Controllers\AvailabilityBatchController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;
use App\Models\Availability;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [RegistrationController::class, 'index'])->name('register.index');
    Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

    Route::prefix('forgot-password')->name('forgot-password.')->group(function () {
        Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
        Route::post('/', [ForgotPasswordController::class, 'store'])->name('store');
    });

    Route::prefix('reset-password')->group(function () {
        Route::get('/{token}', [ForgotPasswordController::class, 'show'])->name('password.reset');
        Route::post('/', [ForgotPasswordController::class, 'update'])->name('reset-password.update');
    });
});

Route::middleware(['auth', 'isVerified'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::prefix('availability-batches')->name('availability-batches.')->group(function () {
        Route::get('/', [AvailabilityBatchController::class, 'index'])->name('index');
        Route::post('/', [AvailabilityBatchController::class, 'store'])->name('store');
        // Route::any('/datatable', [AvailabilityBatchController::class, 'datatable'])->name('datatable');
        Route::get('/create', [AvailabilityBatchController::class, 'create'])->name('create');
        Route::get('/{availabilityBatch}', [AvailabilityBatchController::class, 'show'])->name('show');
        Route::get('/{availabilityBatch}/edit', [AvailabilityBatchController::class, 'edit'])->name('edit');
        Route::put('/{availabilityBatch}', [AvailabilityBatchController::class, 'update'])->name('update');
        Route::delete('/{availabilityBatch}', [AvailabilityBatchController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('availabilities')->group(function () {
        Route::get('/', [AvailabilityController::class, 'index'])->name('availabilities.index');
        Route::post('/', [AvailabilityController::class, 'store'])->name('availabilities.store');
        Route::any('/datatable', [AvailabilityController::class, 'datatable'])->name('availabilities.datatable');
        Route::get('/create', [AvailabilityController::class, 'create'])->name('availabilities.create');
        Route::get('/{availability}', [AvailabilityController::class, 'show'])->name('availabilities.show');
        Route::get('/{availability}/edit', [AvailabilityController::class, 'edit'])->name('availabilities.edit');
        Route::put('/{availability}', [AvailabilityController::class, 'update'])->name('availabilities.update');
        Route::get('/{availability}/delete', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');
    });

    Route::prefix('meetings')->group(function () {
        Route::get('/', [MeetingController::class, 'index'])->name('meetings.index');
        Route::post('/duration', [MeetingController::class, 'duration'])->name('meetings.duration');
        Route::post('/dates', [MeetingController::class, 'dates'])->name('meetings.dates');
        Route::post('/', [MeetingController::class, 'store'])->name('meetings.store');
        Route::any('/datatable', [MeetingController::class, 'datatable'])->name('meetings.datatable');
        Route::get('/create', [MeetingController::class, 'create'])->name('meetings.create');
        Route::get('/{meeting}', [MeetingController::class, 'show'])->name('meetings.show');
        Route::get('/{meeting}/edit', [MeetingController::class, 'edit'])->name('meetings.edit');
        Route::put('/{meeting}', [MeetingController::class, 'update'])->name('meetings.update');
        Route::get('/{meeting}/delete', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    });
});


Route::middleware(['auth', 'isVerified:0'])->group(function () {
    Route::prefix('verification')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('verification.index');
        Route::get('/create', [VerificationController::class, 'create'])->name('verification.create');
        Route::post('/', [VerificationController::class, 'store'])->name('verification.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});


Route::prefix('google')->group(function () {
    Route::get('/', [SocialController::class, 'googleRedirect'])->name('google.redirect');

    Route::get('/callback', [SocialController::class, 'googleCallback'])->name('google.callback');
});
