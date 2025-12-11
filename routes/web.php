<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenjangController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('requestOTP', 'request');
    Route::get('checkOtp', 'checkOtp');
    Route::get('logout', 'logout')->name('logout');
});

Route::middleware(['logged'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('auth', 'login');
    });
});
Route::get('no-akses', function () {
    return view('auth.notauthorize');
})->name('notAuthorize');

Route::middleware(['auth'])->group(function () {
    Route::get('/',  [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/notifikasisaya', function () {
        return auth()->user()->notifikasi;
    });

    Route::prefix('dpd')->group(function () {
        Route::get('dataCombo', [DashboardController::class, 'dataComboDpd']);
    });

    Route::prefix('dpw')->group(function () {
        Route::get('dataCombo', [DashboardController::class, 'dataComboDpw']);
    });

    Route::controller(AnggotaController::class)->group(function () {
        Route::prefix('anggota')->group(function () {
            Route::get('', 'index')->name('kader');
            Route::get('data', 'getData');
        });
    });

    Route::controller(KaderController::class)->group(function () {
        Route::prefix('kader')->group(function () {
            Route::get('', 'index')->name('kader');
            Route::get('data', 'getData');
            Route::get('dataHistori/{anggota}', 'getDataHistori');
            Route::post('addKader', 'addKader')->name('addKader');
            Route::post('importKader', 'importKader')->name('importKader');
            Route::post('updateJenjangAnggota', 'updateJenjang')->name('updateJenjangAnggota');
            Route::get('/{anggota}', 'view')->name('viewKader');
        });
    });

    Route::controller(JenjangController::class)->group(function () {
        Route::prefix('referensi')->group(function () {
            Route::prefix('jenjang')->group(function () {
                Route::get('data', 'getData');
                Route::get('create', 'create');
                Route::get('dataCombo', 'getDatas');
                Route::post('delete', 'delete')->name('saveJenjang');
                Route::post('save', 'save')->name('saveJenjang');
                Route::post('update', 'update')->name('updateJenjang');
                Route::get('/', 'index')->name('jenjang');
                Route::get('/{jenjang}', 'view');
            });
        });
    });

    Route::controller(MonitoringController::class)->group(function () {
        Route::prefix('monitoring')->group(function () {
            Route::get('data', 'getData');
        });
    });
    Route::controller(FeedbackController::class)->group(function () {
        Route::prefix('feedback')->group(function () {
            Route::get('/', 'index')->name('feedback');
            Route::get('data', 'getData');
            Route::get('create', 'create');
            Route::get('dataCombo', 'getDatas');
            Route::post('delete', 'delete')->name('deleteFeedback');
            Route::post('save', 'save')->name('saveFeedback');
            Route::post('update', 'update')->name('updateFeedback');
        });
    });
});
