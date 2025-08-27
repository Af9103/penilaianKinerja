<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\UserController;
use App\Models\Penilaian;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('check.login');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['check.login']);
Route::get('/pegawai', [UserController::class, 'index'])->middleware(['check.adminOratasan']);
Route::get('/user/tambah', [UserController::class, 'show'])->middleware(['check.admin']);
Route::post('/user/tambah', [UserController::class, 'save'])->middleware(['check.admin']);
Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware(['check.admin']);
Route::get('/user/profile/{id}', [UserController::class, 'profile'])->middleware(['check.login']);

Route::get('/penilaian', [PenilaianController::class, 'show'])->middleware(['check.atasan']);
Route::post('/penilaian/store', [PenilaianController::class, 'store'])->middleware(['check.atasan']);
Route::get('/penilaian/hasil', [PenilaianController::class, 'hasil'])->name('penilaian.hasil')->middleware(['check.adminOratasan']);
Route::get('/penilaian/histori/{user_id}', [PenilaianController::class, 'histori'])->middleware(['check.adminOratasan']);

// route khusus untuk ambil data ke modal edit
Route::get('/penilaian/{id}/edit-data', [PenilaianController::class, 'getData'])->middleware(['check.atasan']);
Route::put('/penilaian/{id}', [PenilaianController::class, 'update'])->middleware(['check.atasan']);

Route::get('/rekomendasi_promosi', [SpkController::class, 'promosi'])->name('spk.promosi')->middleware(['check.adminOratasan']);
Route::get('/evaluasi', [SpkController::class, 'evaluasi'])->name('spk.evaluasi')->middleware(['check.adminOratasan']);
Route::get('/bobot', [SpkController::class, 'bobot'])->name('spk.bobot')->middleware(['check.admin']);
Route::put('/bobot/update', [SpkController::class, 'update'])->name('bobot.update')->middleware(['check.admin']);

Route::put('/spk/promosi/{id}', [SpkController::class, 'Updatepromosi'])->name('spk.promosi')->middleware(['check.atasan']);

Route::get('/lap-evaluasi', [SpkController::class, 'laporanEvaluasi'])->middleware(['check.adminOratasan']);

Route::get('/search', [UserController::class, 'search'])->middleware(['check.adminOratasan']);
Route::get('/fetch-all', [UserController::class, 'fetchAll'])->middleware(['check.adminOratasan']);


