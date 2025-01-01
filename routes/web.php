<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UangMasukController;
use App\Http\Controllers\UangKeluarController;

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

//buat jika akses pertama web
Route::get('/', [AuthController::class, 'login'])->middleware('guest')->name('auth.login');
//batas route

//buat login
Route::prefix('auth')->group(function () {

  Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
  });

  Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('login', [AuthController::class, 'post'])->name('auth.login');

  });
});
//batas route login

//check apakah sudah login
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  //uang masuk buat create data masuk
  Route::prefix('uang_masuk')->middleware('auth')->group(function () {
    Route::get('index', [UangMasukController::class, 'index'])->name('uang_masuk.index');
    Route::get('create', [UangMasukController::class, 'create'])->name('uang_masuk.create');
    Route::post('create', [UangMasukController::class, 'store'])->name('uang_masuk.create');
    Route::get('edit/{id}', [UangMasukController::class, 'edit'])->name('uang_masuk.edit');
    Route::put('edit/{id}', [UangMasukController::class, 'update'])->name('uang_masuk.update');
    Route::delete('delete/{id}', [UangMasukController::class, 'destroy'])->name('uang_masuk.delete');
  });
  //batas uang masuk

  //uang keluar buat create uang keluar
  Route::prefix('uang_keluar')->middleware('auth')->group(function () {
    Route::get('index', [UangKeluarController::class, 'index'])->name('uang_keluar.index');
    Route::get('create', [UangKeluarController::class, 'create'])->name('uang_keluar.create');
    Route::post('create', [UangKeluarController::class, 'store'])->name('uang_keluar.create');
    Route::get('edit/{id}', [UangKeluarController::class, 'edit'])->name('uang_keluar.edit');
    Route::put('edit/{id}', [UangKeluarController::class, 'update'])->name('uang_keluar.update');
    Route::delete('delete/{id}', [UangKeluarController::class, 'destroy'])->name('uang_keluar.delete');
  });
  //batas uang keluar

});