<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ClinicAddressController;
use App\Http\Controllers\ClinicDashboardController;
use App\Http\Controllers\ClinicInvitationResend;
use App\Http\Controllers\ClinicProfileController;
use App\Http\Controllers\ClinicSpecialistController;
use App\Http\Controllers\ClinicSpecialistsInvitation;
use App\Http\Controllers\ClinicSpecialistsRatingController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\EducationDegreeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\OnlineConsultationPlatformController;
use App\Http\Controllers\PasswordValidationController;
use App\Http\Controllers\PatientConsultationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientSpecialists;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PremiumPlanListController;
use App\Http\Controllers\PremiumPlansController;
use App\Http\Controllers\PremiumPricingInquiryController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RatingDisputeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SecurityMeasuresController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SpecialistChangesController;
use App\Http\Controllers\SpecialistClinicController;
use App\Http\Controllers\SpecialistClinicInvitationResend;
use App\Http\Controllers\SpecialistClinicsInvitation;
use App\Http\Controllers\SpecialistConsultationController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\SpecialistDashboardController;
use App\Http\Controllers\SpecialistRatingController;
use App\Http\Controllers\SpecialistProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SpecialistProfileServicesController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\UneaseController;
use App\Http\Controllers\VerifyAccountController;
use App\Http\Controllers\RatingFeedbackController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


// Front end routes
Route::middleware(['admin.redirect'])->group(function () {
    Route::get('/', [FrontEndController::class, 'index'])->name('front.home');
    Route::get('/search', SearchController::class)->name('search.index');
    Route::get('/consultation/{doctor}/{address}', [ConsultationController::class, 'create'])->name('consultation.create');
    Route::post('/consultations/', [ConsultationController::class, 'store'])->name('consultation.store');
    Route::get('/consultations/{consultation}/confirm', [ConsultationController::class, 'confirm'])->name('consultation.confirm');
    Route::get('/planes-premium', PremiumPlanListController::class)->name('front.pricing');
    //Route::middleware('auth')->group(function () {
        Route::get('/plan-premium-contacto', [PremiumPricingInquiryController::class, 'index'])->name('front.pricing-inquiry-index');
        Route::post('/plan-premium-contacto', [PremiumPricingInquiryController::class, 'store'])->name('front.pricing-inquiry-store');
    //});
    Route::get('/solicitud-enviada', function () {
        if (!session('inquiry_success')) {
            return view('errors.404');
        }
        return view('front.pricing-inquiry.created-success');
    })->name('front.pricing-inquiry-done');
    Route::get('/faq', function () {
        return view('front.faq');
    })->name('front.faq');
    Route::get('/aviso-legal', function () {
        return view('front.legal-notice');
    })->name('front.legal-notice');
    Route::get('/politica-privacidad', function () {
        return view('front.privacy-policy');
    })->name('front.privacy-policy');
    Route::get('/politica-cookies', function () {
        return view('front.cookies-policy');
    })->name('front.cookies-policy');

});

// Admin Back office routes
Route::domain(config('app.admin_backend'))->group(function () {
    Route::middleware(['auth','active','admin'])->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('admin.dashboard');

        // Sort models
        Route::put('/specialities/sort', [SpecialityController::class, 'sort'])->name('specialities.sort');
        Route::put('/services/sort', [ServiceController::class, 'sort'])->name('services.sort');
        Route::put('/diseases/sort', [DiseaseController::class, 'sort'])->name('diseases.sort');
        Route::put('/uneasiness/sort', [UneaseController::class, 'sort'])->name('uneasiness.sort');
        Route::put('/payment-methods/sort', [PaymentMethodController::class, 'sort'])->name('payment-methods.sort');
        Route::put('/security-measures/sort', [SecurityMeasuresController::class, 'sort'])->name('security-measures.sort');
        Route::put('/online-platforms/sort', [OnlineConsultationPlatformController::class, 'sort'])->name('online-platforms.sort');
        Route::put('/rating-feedback/sort', [RatingFeedbackController::class, 'sort'])->name('rating-feedback.sort');
        Route::put('/social-media/sort', [SocialMediaController::class, 'sort'])->name('social-media.sort');
        Route::put('/education-degree/sort', [EducationDegreeController::class, 'sort'])->name('education-degree.sort');
        Route::put('/premium-plan/sort', [PremiumPlansController::class, 'sort'])->name('premium-plan.sort');

        // Specialities routes
        Route::resource('/specialities', SpecialityController::class);
        Route::resource('/services', ServiceController::class);
        Route::resource('/diseases', DiseaseController::class);
        Route::resource('/uneasiness', UneaseController::class);
        Route::resource('/payment-methods', PaymentMethodController::class);
        Route::resource('/security-measures', SecurityMeasuresController::class);
        Route::resource('/online-platforms', OnlineConsultationPlatformController::class);
        Route::resource('/doctors', SpecialistController::class);
        Route::resource('/patients', PatientController::class);
        Route::resource('/rating-feedback', RatingFeedbackController::class);
        Route::resource('/social-media', SocialMediaController::class);
        Route::resource('/education-degree', EducationDegreeController::class);
        Route::resource('/premium-plan', PremiumPlansController::class);
        Route::get('/changes', [SpecialistChangesController::class, 'index'])->name('changes.index');
        Route::get('/changes/{doctor}', [SpecialistChangesController::class, 'show'])->name('changes.show');
        Route::get('/rating-disputes', [RatingDisputeController::class, 'index'])->name('rating-dispute.index');
        Route::get('/rating-disputes/{dispute}', [RatingDisputeController::class, 'show'])->name('rating-dispute.show');
        Route::prefix('config')->name('config.')->group(function () {
            Route::resource('/users', AdminController::class);
            Route::resource('/permissions', PermissionController::class);
            Route::resource('/roles', RoleController::class);
        });
    });
});

// Registered user routes
Route::middleware(['auth','active'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isSpecialist) {
            return redirect(\route('specialist.dashboard'));
        }
        if (auth()->user()->isClinic) {
            return redirect(\route('clinic.dashboard'));
        }
        return view('dashboard');
    })->name('dashboard');
    // Account routes
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account/edit', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::post('/user/password/validate', PasswordValidationController::class);
    Route::get('/account/send-verification', VerifyAccountController::class)->name('account.send-verification');
    Route::get('/account/{patient}/consultations', [PatientConsultationController::class, 'index'])->name('account.consultations.index');
    Route::get('/account/{patient}/consultations/{consultation}', [PatientConsultationController::class, 'show'])->name('account.consultations.show');
    Route::get('/account/{patient}/specialists', [PatientSpecialists::class, 'index'])->name('account.specialists.index');
    Route::get('/account/rating/{patient}/{doctor}/create', [RatingController::class, 'create'])->name('account.feedback.create');
    Route::get('/account/rating/{rating}', [RatingController::class, 'show'])->name('account.feedback.show');
    Route::post('/account/rating/{patient}/{doctor}', [RatingController::class, 'store'])->name('account.feedback.store');
    Route::put('/account/rating/{rating}', [RatingController::class, 'update'])->name('account.feedback.update');
});

// Specialists back office routes
Route::middleware(['auth', 'specialist','active'])->group(function () {
    // Specialists dashboard
    Route::get('/dashboard/specialist', SpecialistDashboardController::class)->name('specialist.dashboard');
    // Edit specialist routes
    Route::get('/profile/specialist/{uuid}/edit', [SpecialistProfileController::class, 'edit'])->name('specialist.edit');

    Route::put('/profile/specialist/{uuid}', [SpecialistProfileController::class, 'update'])->name('specialist.update');

    // Specialist ratings
    Route::get('/profile/specialist/{uuid}/rating', [SpecialistRatingController::class, 'index'])->name('specialist.ratings.index');

    Route::get('/profile/specialist/{uuid}/rating/{rating}', [SpecialistRatingController::class, 'show'])->name('specialist.ratings.show');
    Route::put('/profile/specialist/{uuid}/rating/{rating}', [SpecialistRatingController::class, 'update'])->name('specialist.ratings.update');

    // Specialist's address routes
    Route::get('/profile/specialist/{uuid}/addresses', [AddressController::class, 'index'])->name('specialist.addresses.index');

    Route::post('/profile/specialist/{uuid}/addresses', [AddressController::class, 'store'])->name('specialist.addresses.store');

    Route::get('/profile/specialist/{uuid}/addresses/new', [AddressController::class, 'create'])->name('specialist.addresses.create');

    Route::get('/profile/specialist/{uuid}/addresses/{address}/edit', [AddressController::class, 'edit'])->name('specialist.addresses.edit');

    Route::put('/profile/specialist/{uuid}/addresses/{address}', [AddressController::class, 'update'])->name('specialist.addresses.update');

    Route::delete('/profile/specialist/{uuid}/addresses/{address}/delete', [AddressController::class, 'destroy'])->name('specialist.address.destroy');

    Route::get('/profile/specialist/{doctor}/consultations/', [SpecialistConsultationController::class, 'index'])->name('specialist.consultations.index');

    Route::get('/profile/specialist/{doctor}/consultations/{consultation}', [SpecialistConsultationController::class, 'show'])->name('specialist.consultations.show');

    // Specialist's services routes
    Route::get('/profile/specialist/{uuid}/services', [SpecialistProfileServicesController::class, 'index'])->name('specialist.services.index');

    Route::post('/profile/specialist/{uuid}/services', [SpecialistProfileServicesController::class, 'store'])->name('specialist.services.store');

    Route::get('/profile/specialist/{uuid}/services/new', [SpecialistProfileServicesController::class, 'create'])->name('specialist.services.create');

    Route::get('/profile/specialist/{uuid}/services/{service}/edit', [SpecialistProfileServicesController::class, 'edit'])->name('specialist.services.edit');

    Route::put('/profile/specialist/{uuid}/services/{service}', [SpecialistProfileServicesController::class, 'update'])->name('specialist.services.update');

    Route::delete('/profile/specialist/{uuid}/services/{service}/delete', [SpecialistProfileServicesController::class, 'destroy'])->name('specialist.services.destroy');


    // Specialists' clinics routes
    Route::get('/profile/specialist/{uuid}/clinics', [SpecialistClinicController::class, 'index'])->name('specialist.clinics.index');
    Route::post('/profile/specialist/{clinic}/invitations/resend', SpecialistClinicInvitationResend::class)->name('specialist.invitations.resend');
    Route::delete('/profile/specialist/{uuid}/clinics/{clinicSpecialist}', [SpecialistClinicController::class, 'destroy'])->name('specialist.clinics.destroy');

    // Specialist clinic invitation
    Route::get('/profile/specialist/{uuid}/clinics/accept/{token}', [SpecialistClinicsInvitation::class, 'store'])->name('specialist.clinics.accept');
    Route::get('/profile/specialist/{uuid}/clinics/reject/{token}', [SpecialistClinicsInvitation::class, 'destroy'])->name('specialist.clinics.reject');
});

// Clinic back office routes
Route::middleware(['auth', 'clinic', 'active'])->group(function () {
    // Specialists dashboard
    Route::get('/dashboard/clinic', ClinicDashboardController::class)->name('clinic.dashboard');

    // Edit clinic routes
    Route::get('/profile/clinic/{uuid}/edit', [ClinicProfileController::class, 'edit'])->name('clinic.edit');

    Route::put('/profile/clinic/{uuid}', [ClinicProfileController::class, 'update'])->name('clinic.update');

    // Clinic's addresses routes
    Route::get('/profile/clinic/{uuid}/addresses', [ClinicAddressController::class, 'index'])->name('clinic.addresses.index');

    Route::post('/profile/clinic/{uuid}/addresses', [ClinicAddressController::class, 'store'])->name('clinic.addresses.store');

    Route::get('/profile/clinic/{uuid}/addresses/new', [ClinicAddressController::class, 'create'])->name('clinic.addresses.create');

    Route::get('/profile/clinic/{uuid}/addresses/{address}/edit', [ClinicAddressController::class, 'edit'])->name('clinic.addresses.edit');

    Route::put('/profile/clinic/{uuid}/addresses/{address}', [ClinicAddressController::class, 'update'])->name('clinic.addresses.update');

    Route::delete('/profile/clinic/{uuid}/addresses/{address}/delete', [ClinicAddressController::class, 'destroy'])->name('clinic.address.destroy');

    // Clinics specialists routes
    Route::get('/profile/clinic/{uuid}/specialists', [ClinicSpecialistController::class, 'index'])->name('clinic.specialists.index');
    Route::put('/profile/clinic/{uuid}/specialists/{clinicSpecialist}', [ClinicSpecialistController::class, 'update'])->name('clinic.specialists.update');
    Route::delete('/profile/clinic/{uuid}/specialists/{clinicSpecialist}', [ClinicSpecialistController::class, 'destroy'])->name('clinic.specialists.destroy');
    Route::post('/profile/clinic/{doctor}/invitations/resend', ClinicInvitationResend::class)->name('clinic.invitations.resend');

    // Clinic specialist's ratings
    Route::get('/profile/clinic/{uuid}/rating', [ClinicSpecialistsRatingController::class, 'index'])->name('clinic.ratings.index');

    Route::get('/profile/clinic/{uuid}/rating/{rating}', [ClinicSpecialistsRatingController::class, 'show'])->name('clinic.ratings.show');

    // Specialist clinic invitation
    Route::get('/profile/clinic/{uuid}/specialists/accept/{token}', [ClinicSpecialistsInvitation::class, 'store'])->name('clinics.specialist.accept');
    Route::get('/profile/clinic/{uuid}/specialists/reject/{token}', [ClinicSpecialistsInvitation::class, 'destroy'])->name('clinics.specialist.reject');
});

// View specialist public profile
Route::get('/psicologos/{specialist}/{uuid}', [SpecialistProfileController::class, 'show'])->name('specialist.show');

// View clinic public profile
Route::get('/centro-medico/{medical_center}/{uuid}', [ClinicProfileController::class, 'show'])->name('clinic.show');

require __DIR__.'/auth.php';
