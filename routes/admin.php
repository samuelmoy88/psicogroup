<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpecialistProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecialistProfileServicesController;
use Illuminate\Support\Facades\Route;


Route::domain('admin.psicogroup.test')->group(function ($router) {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
});
