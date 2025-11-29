<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'loginPage'])->name('login');
Route::get('/register', [HomeController::class, 'registerPage'])->name('register');
Route::get('/patient-portal', [HomeController::class, 'patientPortal'])->name('patient-portal');
Route::get('/professional-portal', [HomeController::class, 'professionalPortal'])->name('professional-portal');
