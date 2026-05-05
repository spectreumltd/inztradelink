<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\EmailOtpVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Supplier\ProfileController as SupplierProfileController;

Route::get('/', function () {
    return view('welcome');
});

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/supplier-sign-up', [IndexController::class, 'supplierRegister'])->name('supplier-sign-up');
    Route::post('/supplier-sign-up', [IndexController::class, 'supplierRegisterStore'])->name('supplier-sign-up.store');
    
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');

    Route::get('/forgot-password-email', [LoginController::class, 'forgotPasswordEmail'])->name('forgot-password-email');
    Route::post('/forgot-password-email-verification', [LoginController::class, 'forgotPasswordEmailVerification'])->name('forgot-password-email-verification');
    Route::get('/forgot-password-otp', [LoginController::class, 'forgotPasswordOtp'])->name('forgot-password-otp');
    Route::post('/forgot-password-otp-verification', [LoginController::class, 'forgotPasswordOtpVerification'])->name('forgot-password-otp-verification');
    Route::get('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password');
    Route::post('/reset-password', [LoginController::class, 'resetPasswordPost'])->name('reset-password.store');

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', fn () => view('auth.verify'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function (): void {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::get('/sendemailotp', [EmailOtpVerificationController::class, 'sendEmailOtp'])->name('sendemailotp');
    Route::get('/resendemailotp', [EmailOtpVerificationController::class, 'resendEmailOtp'])->name('resendemailotp');
    Route::post('/emailotpverification', [EmailOtpVerificationController::class, 'emailOtpVerification'])->name('emailotpverification');
});

Route::group(['prefix' => 'supplier', 'middleware' => ['auth', 'supplier'], 'as' => 'supplier.'], function (): void {
    Route::get('/sendemailotp', [EmailOtpVerificationController::class, 'sendEmailOtp'])->name('sendemailotp');
    Route::get('/resendemailotp', [EmailOtpVerificationController::class, 'resendEmailOtp'])->name('resendemailotp');
    Route::post('/emailotpverification', [EmailOtpVerificationController::class, 'emailOtpVerification'])->name('emailotpverification');
});

Route::group(['prefix' => 'supplier', 'middleware' => ['auth', 'supplier', 'verified'], 'as' => 'supplier.'], function (): void {
    Route::get('/dashboard', [SupplierDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SupplierProfileController::class, 'index'])->name('profile');
    
});




