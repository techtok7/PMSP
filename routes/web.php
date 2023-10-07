<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Authentication\VerificationController;
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
});

Route::middleware(['auth', 'isVerified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');
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
