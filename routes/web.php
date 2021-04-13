<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SecurityMeasuresController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SpecialistChangesController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\SpecialistDashboardController;
use App\Http\Controllers\SpecialistsProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SpecialistProfileServicesController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\UneaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(config('app.admin_backend'))->group(function ($router) {
    Route::middleware(['auth','active','admin'])->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');
        Route::permanentRedirect('/', \App\Providers\RouteServiceProvider::DASHBOARD);

        // Sort models
        Route::put('/specialities/sort', [SpecialityController::class, 'sort'])->name('specialities.sort');
        Route::put('/services/sort', [ServicesController::class, 'sort'])->name('services.sort');
        Route::put('/diseases/sort', [DiseaseController::class, 'sort'])->name('diseases.sort');
        Route::put('/uneasiness/sort', [UneaseController::class, 'sort'])->name('uneasiness.sort');
        Route::put('/payment-methods/sort', [PaymentMethodController::class, 'sort'])->name('payment-methods.sort');
        Route::put('/security-measures/sort', [SecurityMeasuresController::class, 'sort'])->name('security-measures.sort');

        // Specialities routes
        Route::resource('/specialities', SpecialityController::class);
        Route::resource('/services', ServicesController::class);
        Route::resource('/diseases', DiseaseController::class);
        Route::resource('/uneasiness', UneaseController::class);
        Route::resource('/payment-methods', PaymentMethodController::class);
        Route::resource('/security-measures', SecurityMeasuresController::class);
        Route::resource('/doctors', SpecialistController::class);
        Route::resource('/patients', PatientsController::class);
        Route::get('/changes', [SpecialistChangesController::class, 'index'])->name('changes.index');
        Route::get('/changes/{doctor}', [SpecialistChangesController::class, 'show'])->name('changes.show');
        Route::prefix('config')->name('config.')->group(function () {
            Route::resource('/users', AdminController::class);
            Route::resource('/permissions', PermissionsController::class);
            Route::resource('/roles', RolesController::class);
        });
    });
});

Route::middleware(['auth','active'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    // Account routes
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account/edit', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::post('/user/password/validate', \App\Http\Controllers\PasswordValidationController::class);
});

Route::middleware(['auth', 'specialist','active'])->group(function () {
    // Specialists dashboard
    Route::get('/dashboard', SpecialistDashboardController::class)->name('specialist.dashboard');
    // Specialist routes
    Route::get('/profile/{uuid}/edit', [SpecialistsProfileController::class, 'edit'])->name('specialist.edit');

    Route::put('/profile/{uuid}', [SpecialistsProfileController::class, 'update'])->name('specialist.update');

    // Specialist's address routes
    Route::get('/profile/{uuid}/addresses', [AddressController::class, 'index'])->name('specialist.addresses.index');

    Route::post('/profile/{uuid}/addresses', [AddressController::class, 'store'])->name('specialist.addresses.store');

    Route::get('/profile/{uuid}/addresses/new', [AddressController::class, 'create'])->name('specialist.addresses.create');

    Route::get('/profile/{uuid}/addresses/{address}/edit', [AddressController::class, 'edit'])->name('specialist.addresses.edit');

    Route::put('/profile/{uuid}/addresses/{address}', [AddressController::class, 'update'])->name('specialist.addresses.update');

    Route::delete('/profile/{uuid}/addresses/{address}/delete', [AddressController::class, 'destroy'])->name('specialist.address.destroy');

    // Specialist's services routes
    Route::get('/profile/{uuid}/services', [SpecialistProfileServicesController::class, 'index'])->name('specialist.services.index');

    Route::post('/profile/{uuid}/services', [SpecialistProfileServicesController::class, 'store'])->name('specialist.services.store');

    Route::get('/profile/{uuid}/services/new', [SpecialistProfileServicesController::class, 'create'])->name('specialist.services.create');

    Route::get('/profile/{uuid}/services/{service}/edit', [SpecialistProfileServicesController::class, 'edit'])->name('specialist.services.edit');

    Route::put('/profile/{uuid}/services/{service}', [SpecialistProfileServicesController::class, 'update'])->name('specialist.services.update');

    Route::delete('/profile/{uuid}/services/{service}/delete', [SpecialistProfileServicesController::class, 'destroy'])->name('specialist.services.destroy');
});

// View public profile
Route::get('/{specialist}/psicologo/{uuid}', [SpecialistsProfileController::class, 'show'])->name('specialist.show');

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
