<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;


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

Route::get('/', function () {
    
    return view('welcome');
});

// Admin/Petugas
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::resource('pengaduans', 'PengaduanController');

        Route::resource('tanggapan', 'TanggapanController');

        Route::get('masyarakat', 'AdminController@masyarakat');
        Route::resource('petugas', 'PetugasController');

        Route::get('laporan', 'AdminController@laporan');
        Route::get('laporan/cetak', 'AdminController@cetak');
        Route::get('pengaduan/cetak/{id}', 'AdminController@pdf');
});


// Masyarakat
Route::prefix('user')
    ->middleware(['auth', 'MasyarakatMiddleware'])
    ->group(function() {
				Route::get('/', 'MasyarakatController@index')->name('masyarakat-dashboard');
                Route::resource('pengaduan', 'MasyarakatController');
                Route::get('pengaduan', 'MasyarakatController@lihat');
});

Route::post('/submit-rating', 'RatingController@submitRating')->name('submit-rating');
Route::post('/submit-prioritas', 'PengaduanController@submitPrioritas')->name('submit-prioritas');
Route::post('/submit-menangani', 'PengaduanController@submitMenangani')->name('submit-menangani');
Route::get('/admin/rating', 'RatingController@index')->name('rating.index');
Route::get('/chartBidang', 'RatingController@chartBidang')->name('chartBidang');
Route::get('/chartPetugas', 'RatingController@chartPetugas')->name('chartPetugas');
Route::get('/chartDetailPetugas', 'RatingController@chartDetailPetugas')->name('chartDetailPetugas');

require __DIR__.'/auth.php';
