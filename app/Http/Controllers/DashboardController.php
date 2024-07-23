<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $bidangPetugas = Auth::user()->bidang;
        return view('pages.admin.dashboard',[
            'pengaduan' => Pengaduan::count(),
            // 'pengaduanp' => Pengaduan::join('users', 'pengaduans.jenis_pengaduan', '=', 'users.bidang')
            //                         ->where('users.bidang', '=', Auth::user()->bidang)
            //                         ->count(),
            'pengaduanp' => Pengaduan::whereHas('petugas', function ($query) use ($bidangPetugas) {
                                $query->where('bidang', $bidangPetugas);
                            })->count(),
            'user' => User::where('roles','=', 'USER')->count(),
            'petugas' => User::where('roles', '=', 'PETUGAS')->count(),
            'admin' => User::where('roles', '=', 'ADMIN')->count(),
            'tanggapan' => Tanggapan::count(),
            'pending' => Pengaduan::where('status', 'Belum di Proses')->count(),
            'process' => Pengaduan::where('status', 'Sedang di Proses')->count(),
            'success' => Pengaduan::where('status', 'Selesai')->count(),
            // 'belumpetugas' => Pengaduan::where('status', 'Belum di Proses')
            // ->join('users', 'pengaduans.jenis_pengaduan', '=', 'users.bidang')
            //             ->where('users.bidang', '=', Auth::user()->bidang)
            //             ->count(),
            // 'prosespetugas' => Pengaduan::where('status', 'Sedang di Proses')
            //             ->join('users', 'pengaduans.jenis_pengaduan', '=', 'users.bidang')
            //             ->where('users.bidang', '=', Auth::user()->bidang)
            //             ->count(),
            // 'suksespetugas' => Pengaduan::where('status', 'Selesai')
            //             ->join('users', 'pengaduans.jenis_pengaduan', '=', 'users.bidang')
            //             ->where('users.bidang', '=', Auth::user()->bidang)
            //             ->count(),
            'belumpetugas' => Pengaduan::where('status', 'Belum di Proses')
                                ->whereHas('petugas', function ($query) use ($bidangPetugas) {
                                    $query->where('bidang', $bidangPetugas);
                                })->count(),
            'prosespetugas' => Pengaduan::where('status', 'Sedang di Proses')
                                ->whereHas('petugas', function ($query) use ($bidangPetugas) {
                                    $query->where('bidang', $bidangPetugas);
                                })->count(),
            'suksespetugas' => Pengaduan::where('status', 'Selesai')
                                ->whereHas('petugas', function ($query) use ($bidangPetugas) {
                                    $query->where('bidang', $bidangPetugas);
                                })->count(),
            'dataRating' => Pengaduan::select('jenis_pengaduan', 'rating')
                        ->whereNotNull('rating')
                        ->get()
                        ->toArray() // Mengubah ke array
        ]);
    }
}