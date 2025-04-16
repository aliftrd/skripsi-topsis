<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('dashboard'));

Route::middleware(['guest'])->group(function () {
    Route::get('login', AuthController::class)->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::prefix('criteria')->name('criteria.')->group(function () {
        Route::resource('/', CriteriaController::class, [
            'parameters' => ['' => 'criteria:code']
        ]);

        Route::resource('{criteria}/sub-criteria', SubCriteriaController::class)
            ->parameters(['sub-criteria' => 'subcriteria'])
            ->except(['index', 'show']);
    });

    Route::prefix('citizen')->name('citizen.')->group(function () {
        Route::resource('/', CitizenController::class, [
            'parameters' => ['' => 'citizen:code']
        ]);

        Route::post('/import', [CitizenController::class, 'import'])->name('import');
    });


    Route::get('assessment', AssessmentController::class)->name('assessment');

    Route::prefix('calculation')->name('calculation.')->group(function () {
        Route::get('/', CalculationController::class)->name('index');
        Route::get('/export', [CalculationController::class, 'export'])->name('export');
    });

    Route::resource('user', UserController::class);
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', ProfileController::class)->name('index');
        Route::put('/', [ProfileController::class, 'updateProfile'])->name('update-profile');
        Route::get('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::put('update-password', [ProfileController::class, 'doUpdatePassword'])->name('do-update-password');
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
