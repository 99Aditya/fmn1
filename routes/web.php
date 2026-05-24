<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/community', [HomeController::class, 'community']);
Route::get('/ats', [HomeController::class, 'ats']);
Route::get('/mock', [HomeController::class, 'mock']);
Route::get('/mcq-challenge', [HomeController::class, 'mcqChallenge']);
Route::get('/mcq-test', [HomeController::class, 'mcqTest']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);