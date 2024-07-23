<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduansController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'loginapi']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/create-pengaduan', [PengaduansController::class, 'createPengaduan']);
Route::get('/get-all-pengaduan', [PengaduansController::class, 'getAllPengaduan']);
Route::get('/detail-pengaduan/{id}', [PengaduansController::class, 'getPengaduanById']);
Route::put('/pengaduan/{id}/rating', [PengaduansController::class, 'addRating']);
Route::put('/pengaduan/{id}/detail-rating', [PengaduansController::class, 'submitDetailRating']);
Route::get('/pengaduan/{user_nik}', [PengaduansController::class, 'getPengaduanByUserNik']);
Route::get('/pengaduan/status/{user_nik}', [PengaduansController::class, 'getPengaduanByUserNikStatus']);
Route::get('/pengaduan/tidakselesai/{user_nik}', [PengaduansController::class, 'getPengaduanByUserNikStatusTidakSelesai']);
Route::get('/tanggapan/{pengaduanId}', [TanggapanController::class, 'getTanggapanByPengaduanId']);
Route::get('/profile/{nik}', [AuthController::class, 'getUserProfileByNik']);