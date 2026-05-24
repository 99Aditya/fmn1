<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AtsController;

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