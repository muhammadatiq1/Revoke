<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OffboardingController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Public home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Employee routes
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    });

    // Software routes
    Route::prefix('softwares')->name('softwares.')->group(function () {
        Route::get('/', [SoftwareController::class, 'index'])->name('index');
        Route::get('/create', [SoftwareController::class, 'create'])->name('create');
        Route::post('/', [SoftwareController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [SoftwareController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{software}', [SoftwareController::class, 'show'])->name('show');
        Route::get('/{software}/edit', [SoftwareController::class, 'edit'])->name('edit');
        Route::put('/{software}', [SoftwareController::class, 'update'])->name('update');
        Route::delete('/{software}', [SoftwareController::class, 'destroy'])->name('destroy');
    });

    // Offboarding routes
    Route::prefix('offboarding')->name('offboarding.')->group(function () {
        Route::get('/', [OffboardingController::class, 'index'])->name('index');
        Route::get('/{employee}/initiate', [OffboardingController::class, 'initiate'])->name('initiate');
        Route::patch('/bulk-revoke', [OffboardingController::class, 'bulkRevoke'])->name('bulk-revoke');
        Route::get('/{employee}', [OffboardingController::class, 'show'])->name('show');
        Route::post('/{employee}', [OffboardingController::class, 'store'])->name('store');
        Route::patch('/revoke/{offboardingTask}', [OffboardingController::class, 'revoke'])->name('revoke');
    });

    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::get('/{report}', [ReportController::class, 'show'])->name('show');
        Route::post('/offboarding', [ReportController::class, 'generateOffboardingReport'])->name('offboarding');
        Route::post('/software-audit', [ReportController::class, 'generateSoftwareAuditReport'])->name('software-audit');
        Route::post('/risk-assessment', [ReportController::class, 'generateRiskAssessmentReport'])->name('risk-assessment');
        Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
    });

    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('update-general');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('update-notifications');
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        Route::put('/security', [SettingsController::class, 'updateSecurity'])->name('update-security');
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('update-profile');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('update-password');
        Route::get('/roles', [SettingsController::class, 'roles'])->name('roles');
    });

    // Roles & Permissions routes
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('/assign-roles', [RoleController::class, 'assignRoles'])->name('assign-roles');
    });

    // User role assignment
    Route::put('/users/{user}/roles', [RoleController::class, 'updateUserRoles']);
});
