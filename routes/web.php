<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Authentication\VerificationController;
use App\Http\Controllers\Authentication\ForgotPasswordController;
use App\Http\Controllers\AvailabilityBatchController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Support\Facades\Route;

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
});


Route::middleware(['auth', 'isVerified:0'])->group(function () {
    Route::prefix('verification')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('verification.index');
        Route::post('/', [VerificationController::class, 'store'])->name('verification.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});
