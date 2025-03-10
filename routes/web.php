<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GdnController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UktController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserAksesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsulanController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'post'])->name('loginPost');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profil/show/{id}',   [AuthController::class, 'profil'])->name('profil');
    Route::get('profil/edit/{id}',   [AuthController::class, 'profilUpdate'])->name('profil.edit');
    Route::get('profil/update/{id}', [AuthController::class, 'profilUpdate'])->name('profil.update');
    Route::get('email',              [AuthController::class, 'email'])->name('email');
    Route::get('emai/update',        [AuthController::class, 'email'])->name('email.update');
    Route::get('emai/delete/{id}',   [AuthController::class, 'emailDelete'])->name('email.delete');

    Route::get('usulan/verif/{id}',   [UsulanController::class, 'verif'])->name('usulan.verif');
    Route::get('usulan/proses/{id}',  [UsulanController::class, 'proses'])->name('usulan.proses');
    Route::get('usulan/daftar/{id}',  [UsulanController::class, 'show'])->name('usulan');
    Route::get('usulan/detail/{id}',  [UsulanController::class, 'detail'])->name('usulan.detail');
    Route::get('usulan/select/{id}',  [UsulanController::class, 'select'])->name('usulan.select');
    Route::get('usulan/surat/{id}',   [UsulanController::class, 'surat'])->name('usulan.surat');
    Route::get('usulan/edit/{id}',    [UsulanController::class, 'edit'])->name('usulan.edit');
    Route::get('usulan/delete/{id}',  [UsulanController::class, 'delete'])->name('usulan.delete');
    Route::post('usulan/store/{id}',  [UsulanController::class, 'store'])->name('usulan.store');
    Route::post('usulan/update/{id}', [UsulanController::class, 'update'])->name('usulan.update');

    Route::get('usulan/delete-item/{id}',  [UsulanController::class, 'deleteItem'])->name('usulan.deleteItem');

    Route::get('gdn', [GdnController::class, 'index'])->name('gdn');
    Route::get('ukt', [UktController::class, 'index'])->name('ukt');

    // Akses Super User
    Route::group(['middleware' => ['access:user']], function () {

        Route::get('usulan/tambah/{id}',  [UsulanController::class, 'create'])->name('usulan.create');

    });

    // Akses Super User
    Route::group(['middleware' => ['access:monitor']], function () {

        Route::get('kriteria', [PenilaianKriteriaController::class, 'show'])->name('kriteria');

    });

    // Akses Admin
    Route::group(['middleware' => ['access:admin']], function () {

        Route::get('kriteria/store', [PenilaianKriteriaController::class, 'store'])->name('kriteria.store');
        Route::post('kriteria/update/{id}', [PenilaianKriteriaController::class, 'update'])->name('kriteria.update');

    });

    // Akses Super Admin
    Route::group(['middleware' => ['access:master']], function () {

        Route::get('users', [UserController::class, 'show'])->name('users');
        Route::get('users/select', [UserController::class, 'select'])->name('users.select');
        Route::get('users/detail/{id}', [UserController::class, 'detail'])->name('users.detail');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');

        Route::get('pegawai', [PegawaiController::class, 'show'])->name('pegawai');
        Route::get('pegawai/select', [PegawaiController::class, 'select'])->name('pegawai.select');
        Route::get('pegawai/detail/{id}', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::get('pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');
        Route::post('pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::post('pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');

        Route::get('form/store', [FormController::class, 'show'])->name('form');
        Route::post('form/store', [FormController::class, 'store'])->name('form.store');
        Route::post('form/update/{id}', [FormController::class, 'update'])->name('form.update');

        Route::get('uker/store', [UnitKerjaController::class, 'show'])->name('uker');
        Route::post('uker/store', [UnitKerjaController::class, 'store'])->name('uker.store');
        Route::post('uker/update/{id}', [UnitKerjaController::class, 'update'])->name('uker.update');

        Route::get('akses/store', [UserAksesController::class, 'show'])->name('akses');
        Route::post('akses/store', [UserAksesController::class, 'store'])->name('akses.store');
        Route::post('akses/update/{id}', [UserAksesController::class, 'update'])->name('akses.update');

    });
});
