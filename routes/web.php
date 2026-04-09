<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, CheckoutController, ProfileController};
use App\Http\Controllers\Admin\{DashboardController, CvTemplateController, UserController, TransactionController, SettingController};
use App\Http\Controllers\User\{TemplateController, DashboardUserController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LoginAdminController, LogoutController, ForgotPasswordController, MagicLoginController};

Route::controller(HomeController::class)->group(function() {
    Route::get('/', 'home')->name('home');
});

Route::get('logout', function() {
    return back();
});

Route::controller(TemplateController::class)->group(function() {
    Route::get('templates', 'index')->name('templates');
    Route::get('templates-{slug}', 'detail')->name('template-detail');
    Route::get('template-editor-{slug}', 'editor')->name('template-editor');
    Route::post('resume/save', 'save')->name('resume.save');

    Route::get('resume-editor-{id}', 'editResume')->name('resume.edit');
    Route::post('resume/{id}/increment-download', 'incrementDownload')->name('resume.increment-download');
    Route::get('resume/{id}/render', 'renderView')->name('resume.render');
    Route::post('/resume/{id}/rating', 'submitRating')->name('resume.rating');
});

Route::get('pricing', [CheckoutController::class, 'showPricing'])->name('pricing');

Route::controller(MagicLoginController::class)->group(function() {
    Route::prefix('login')->name('login.')->group(function() {
        Route::get('verify/{token}', 'verifyLogin')->name('verify');
    });
});

Route::controller(ForgotPasswordController::class)->group(function() {
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

Route::middleware('guest')->group(function () {

    Route::controller(RegisterController::class)->group(function() {
        Route::get('register', 'show')->name('register');
        Route::post('register', 'store')->name('register.store');
    });
    
    Route::controller(LoginController::class)->group(function() {
        Route::get('login', 'show')->name('login');
        Route::post('login', 'login')->name('login.process');
    });

    Route::controller(MagicLoginController::class)->group(function() {
        Route::prefix('login')->name('login.')->group(function() {
            Route::post('magic', 'sendLoginLink')->name('magic');
        });
    });

    Route::get('admin/login', function () { return abort(404); });

    Route::controller(LoginAdminController::class)->group(function() {
        Route::get('admin/login/$2y$12$Lv1Iu3KAhelYAxCHivrY3e7FiyTD0L.qEomatiC89E8picvbaWOlG', 'show')->name('admin.login');
        Route::post('admin/login', 'loginAdmin')->name('admin.login.process');
    });

    Route::controller(ForgotPasswordController::class)->group(function() {
        Route::get('/forgot-password', 'showForgotForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.send-reset-link');
    });
});

Route::middleware('auth')->group(function() {
    
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

   
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function() {

        Route::controller(DashboardUserController::class)->group(function() {
            Route::get('dashboard', 'index')->name('dashboard');
            Route::get('my-resumes', 'myResumes')->name('resumes');
            Route::prefix('profile')->name('profile.')->group(function() {
                Route::get('{id}', 'showProfile')->name('show');
                Route::get('{id}/edit', 'editProfile')->name('edit');
            });
        });

        Route::controller(ProfileController::class)->prefix('profile')->group(function() {
            Route::get('/', 'index')->name('profile');
            Route::put('update', 'update')->name('profile.update');
            Route::put('cancel-premium', 'cancelPremium')->name('profile.cancel-premium');
        });

        Route::controller(CheckoutController::class)->group(function() {
            Route::get('checkout', 'checkout')->name('checkout');
            Route::post('checkout', 'process')->name('checkout.process');
        });
        Route::get('/isi-data-template', function () { return view('pages.dashboard.form-template'); })->name('form-template');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function() {
        
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        
        Route::prefix('transaksi')->controller(TransactionController::class)->name('transactions.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{transaction}', 'show')->name('show');
            Route::patch('{transaction}/approve', 'approve')->name('approve');
            Route::patch('{transaction}/reject', 'reject')->name('reject');
            Route::delete('{transaction}', 'destroy')->name('destroy');
        });

        Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
            Route::get('{user}/reset-password', 'resetPasswordForm')->name('reset-password.form');
            Route::patch('{user}/reset-password', 'resetPassword')->name('reset-password');
            Route::patch('{user}/toggle-active', 'toggleActive')->name('toggle-active');
            Route::patch('{user}/toggle-premium', 'togglePremium')->name('toggle-premium');
        });
        Route::resource('users', UserController::class); 
        
        Route::resource('templates', CvTemplateController::class)->except(['show']);

        Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function() {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    });
});


Route::get('/kode-otp', function() { return view('auth.otp'); })->name('otp');
Route::get('/email-otp', function() { return view('auth.emailotp'); })->name('emailotp');
Route::get('/modal-test', function() { return view('auth.success'); })->name('modal-test');