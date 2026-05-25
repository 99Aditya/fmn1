<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AtsController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/community', [HomeController::class, 'community']);
Route::get('/ats', [HomeController::class, 'ats']);
Route::post('/ats/upload', [AtsController::class, 'upload'])->name('ats.upload');
Route::get('/ats/process/{id}', [AtsController::class, 'process'])->name('ats.process');
Route::get('/mock', [HomeController::class, 'mock']);
Route::get('/mcq-challenge', [HomeController::class, 'mcqChallenge']);
Route::get('/mcq-test', [HomeController::class, 'mcqTest']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');