<?php

use App\Http\Controllers\AkunAuditeeController;
use App\Http\Controllers\AkunJurusanController;
use App\Http\Controllers\AkunOperatorController;
use App\Http\Controllers\AnggotaAuditorController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalAmiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KepalaP4mpController;
use App\Http\Controllers\LayananAkademikController;
use App\Http\Controllers\LeadAuditorController;
use App\Http\Controllers\PedomanAmiController;
use App\Http\Controllers\PelaksanaanAmiController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\StandarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthenticationController::class, 'index'])->name('web.auth.index');
    Route::post('/', [AuthenticationController::class, 'login'])->name('web.auth.login');
});

Route::middleware(['auth'])->name('web.')->group(function () {
    Route::get('/auth/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');

    Route::prefix('data')->name('data.')->group(function () {
        Route::resource('/jurusan', JurusanController::class);
        Route::resource('/prodi', ProgramStudiController::class);
        Route::resource('/layanan-akademik', LayananAkademikController::class);
    });

    Route::prefix('ami')->name('ami.')->group(function () {
        Route::put('/pelaksanaan-ami/non-active', [PelaksanaanAmiController::class, 'nonActive'])->name('pelaksanaan-ami.non-active');
        Route::resource('/pelaksanaan-ami', PelaksanaanAmiController::class);
        Route::resource('/jadwal-ami', JadwalAmiController::class);
        Route::resource('/pedoman-ami', PedomanAmiController::class);
        Route::resource('/standar', StandarController::class);
    });

    Route::prefix('manage-user')->name('manage-user.')->group(function () {
        Route::put('update-password/{id}', [UserController::class, 'updatePassword'])->name('update-password');
        Route::resource('akun-operator', AkunOperatorController::class);
        Route::resource('kepala-p4mp', KepalaP4mpController::class);
        Route::resource('akun-jurusan', AkunJurusanController::class);
        Route::resource('lead-auditor', LeadAuditorController::class);
        Route::resource('anggota-auditor', AnggotaAuditorController::class);
        Route::resource('akun-auditee', AkunAuditeeController::class);
    });
});
