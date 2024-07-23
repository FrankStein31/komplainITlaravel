<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{

    public function index()
    {
        $dataRating = Pengaduan::with('petugas')
            ->select('id_petugas', 'jenis_pengaduan', 'rating', 'responsivitas', 'sikap', 'komunikasi', 'waktu', 'pemahaman')
            ->whereNotNull('rating')
            ->get();

        $ratingPetugas = $this->getRatingPetugas();
        $ratingPerPetugas = $this->getRatingPerPetugas();
        $detailRatingPerPetugas = $this->getDetailRatingPerPetugas();

        return view('pages.admin.rating.index', compact('dataRating', 'ratingPetugas', 'ratingPerPetugas', 'detailRatingPerPetugas'));
    }

    // private function getRatingPetugas()
    // {
    //     return User::join('pengaduans', 'users.id', '=', 'pengaduans.id_petugas')
    //         ->select(
    //             'users.id',
    //             'users.name',
    //             'users.bidang',
    //             DB::raw('AVG(pengaduans.rating) as avg_rating'),
    //             DB::raw('AVG(pengaduans.responsivitas) as avg_responsivitas'),
    //             DB::raw('AVG(pengaduans.sikap) as avg_sikap'),
    //             DB::raw('AVG(pengaduans.komunikasi) as avg_komunikasi'),
    //             DB::raw('AVG(pengaduans.waktu) as avg_waktu'),
    //             DB::raw('AVG(pengaduans.pemahaman) as avg_pemahaman')
    //         )
    //         ->where('users.roles', 'PETUGAS')
    //         ->whereNotNull('pengaduans.rating')
    //         ->groupBy('users.id', 'users.name', 'users.bidang')
    //         ->orderByDesc('avg_rating')
    //         ->get();
    // }
    // private function getRatingPetugas()
    // {
    //     return User::leftJoin('pengaduans', 'users.id', '=', 'pengaduans.id_petugas')
    //         ->select(
    //             'users.id',
    //             'users.name',
    //             'users.bidang',
    //             DB::raw('COUNT(pengaduans.id) as jumlah_pengaduan'),
    //             DB::raw('AVG(pengaduans.rating) as avg_rating'),
    //             DB::raw('AVG(pengaduans.responsivitas) as avg_responsivitas'),
    //             DB::raw('AVG(pengaduans.sikap) as avg_sikap'),
    //             DB::raw('AVG(pengaduans.komunikasi) as avg_komunikasi'),
    //             DB::raw('AVG(pengaduans.waktu) as avg_waktu'),
    //             DB::raw('AVG(pengaduans.pemahaman) as avg_pemahaman'),
    //             DB::raw('(AVG(pengaduans.responsivitas) + AVG(pengaduans.sikap) + AVG(pengaduans.komunikasi) + AVG(pengaduans.waktu) + AVG(pengaduans.pemahaman)) / 5 as avg_detail')
    //         )
    //         ->where('users.roles', 'PETUGAS')
    //         ->groupBy('users.id', 'users.name', 'users.bidang')
    //         ->orderByDesc('avg_rating')
    //         ->orderByDesc('avg_detail')
    //         ->get();
    // }

    private function getRatingPetugas()
    {
        return User::leftJoin('pengaduans', 'users.id', '=', 'pengaduans.id_petugas')
            ->select(
                'users.id',
                'users.name',
                'users.bidang',
                DB::raw('COUNT(pengaduans.id) as jumlah_pengaduan'),
                DB::raw('AVG(pengaduans.rating) as avg_rating'),
                DB::raw('AVG(pengaduans.responsivitas) as avg_responsivitas'),
                DB::raw('AVG(pengaduans.sikap) as avg_sikap'),
                DB::raw('AVG(pengaduans.komunikasi) as avg_komunikasi'),
                DB::raw('AVG(pengaduans.waktu) as avg_waktu'),
                DB::raw('AVG(pengaduans.pemahaman) as avg_pemahaman'),
                DB::raw('(AVG(pengaduans.responsivitas) + AVG(pengaduans.sikap) + AVG(pengaduans.komunikasi) + AVG(pengaduans.waktu) + AVG(pengaduans.pemahaman)) / 5 as avg_detail')
            )
            ->where('users.roles', 'PETUGAS')
            ->groupBy('users.id', 'users.name', 'users.bidang')
            ->orderByDesc('avg_rating')
            ->orderByDesc('avg_detail')
            ->get();
    }

    public function chartPetugas(Request $request)
    {
        $bidang = $request->input('bidang');
        $ratingPerPetugas = $this->getRatingPerPetugas($bidang);
        return response()->json(['ratingPerPetugas' => $ratingPerPetugas]);
    }

    public function chartDetailPetugas(Request $request)
    {
        $bidang = $request->input('bidang');
        $detailRatingPerPetugas = $this->getDetailRatingPerPetugas($bidang);
        return response()->json(['detailRatingPerPetugas' => $detailRatingPerPetugas]);
    }

    // private function getRatingPerPetugas($bidang = null)
    // {
    //     $query = Pengaduan::whereNotNull('rating')
    //         ->join('users', 'pengaduans.id_petugas', '=', 'users.id')
    //         ->groupBy('pengaduans.id_petugas', 'users.name')
    //         ->selectRaw('users.name as nama_petugas, AVG(pengaduans.rating) as average_rating');

    //     if ($bidang) {
    //         $query->where('pengaduans.jenis_pengaduan', $bidang);
    //     }

    //     return $query->get();
    // }
    private function getRatingPerPetugas($bidang = null)
    {
        $query = User::leftJoin('pengaduans', 'users.id', '=', 'pengaduans.id_petugas')
            ->select('users.name as nama_petugas', DB::raw('AVG(pengaduans.rating) as average_rating'))
            ->where('users.roles', 'PETUGAS')
            ->groupBy('users.id', 'users.name');

        if ($bidang) {
            $query->where('pengaduans.jenis_pengaduan', $bidang);
        }

        return $query->get();
    }


    // private function getDetailRatingPerPetugas($bidang = null)
    // {
    //     $query = Pengaduan::whereNotNull('rating')
    //         ->join('users', 'pengaduans.id_petugas', '=', 'users.id')
    //         ->groupBy('pengaduans.id_petugas', 'users.name')
    //         ->selectRaw('users.name as nama_petugas, 
    //                     AVG(pengaduans.responsivitas) as avg_responsivitas, 
    //                     AVG(pengaduans.komunikasi) as avg_komunikasi, 
    //                     AVG(pengaduans.sikap) as avg_sikap, 
    //                     AVG(pengaduans.waktu) as avg_waktu, 
    //                     AVG(pengaduans.pemahaman) as avg_pemahaman');

    //     if ($bidang) {
    //         $query->where('pengaduans.jenis_pengaduan', $bidang);
    //     }

    //     return $query->get();
    // }
    private function getDetailRatingPerPetugas($bidang = null)
    {
        $query = User::leftJoin('pengaduans', 'users.id', '=', 'pengaduans.id_petugas')
            ->select(
                'users.name as nama_petugas',
                DB::raw('AVG(pengaduans.responsivitas) as avg_responsivitas'),
                DB::raw('AVG(pengaduans.komunikasi) as avg_komunikasi'),
                DB::raw('AVG(pengaduans.sikap) as avg_sikap'),
                DB::raw('AVG(pengaduans.waktu) as avg_waktu'),
                DB::raw('AVG(pengaduans.pemahaman) as avg_pemahaman')
            )
            ->where('users.roles', 'PETUGAS')
            ->groupBy('users.id', 'users.name');

        if ($bidang) {
            $query->where('pengaduans.jenis_pengaduan', $bidang);
        }

        return $query->get();
    }


    // private function getRatingPerPetugas()
    // {
    //     return Pengaduan::whereNotNull('rating')
    //         ->join('users', 'pengaduans.id_petugas', '=', 'users.id')
    //         ->groupBy('pengaduans.id_petugas', 'users.name')
    //         ->selectRaw('users.name as nama_petugas, AVG(pengaduans.rating) as average_rating')
    //         ->get();
    // }

    // private function getDetailRatingPerPetugas()
    // {
    //     return Pengaduan::whereNotNull('rating')
    //         ->join('users', 'pengaduans.id_petugas', '=', 'users.id')
    //         ->groupBy('pengaduans.id_petugas', 'users.name')
    //         ->selectRaw('users.name as nama_petugas, 
    //                     AVG(pengaduans.responsivitas) as avg_responsivitas, 
    //                     AVG(pengaduans.komunikasi) as avg_komunikasi, 
    //                     AVG(pengaduans.sikap) as avg_sikap, 
    //                     AVG(pengaduans.waktu) as avg_waktu, 
    //                     AVG(pengaduans.pemahaman) as avg_pemahaman')
    //         ->get();
    // }

    public function chartBidang(Request $request)
    {
        
        $bidang = $request->input('bidang');
        $data = $this->get_chartBidang($bidang);
        return response()->json($data);
    }

    public function get_chartBidang($bidang)
    {
        $query = Pengaduan::with('petugas')
            ->select('id_petugas', 'jenis_pengaduan', 'rating', 'responsivitas', 'sikap', 'komunikasi', 'waktu', 'pemahaman')
            ->whereNotNull('rating');

        if (!is_null($bidang)){
            $query->where('jenis_pengaduan', $bidang);
        }

        $results = $query->get();

        $data = ['ratings' => [], 'jenis_pengaduan' => [], 'count' => []];

        foreach ($results as $value) {
            $jenis_pengaduan = $value->jenis_pengaduan;
            $rating = $value->rating;

            if (!isset($data['ratings'][$jenis_pengaduan])) {
                $data['ratings'][$jenis_pengaduan] = 0;
                $data['count'][$jenis_pengaduan] = 0;
                $data['jenis_pengaduan'][] = $jenis_pengaduan;
            }

            $data['ratings'][$jenis_pengaduan] += $rating;
            $data['count'][$jenis_pengaduan]++;
        }

        // Menghitung rata-rata
        foreach ($data['jenis_pengaduan'] as $jenis) {
            if ($data['count'][$jenis] > 0) {
                $data['ratings'][$jenis] = $data['ratings'][$jenis] / $data['count'][$jenis];
            }
        }

        unset($data['count']);
        return $data;
    }



    // submit rating
    public function submitRating(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'pengaduan_id' => 'required|exists:pengaduans,id'
        ]);

        // Ambil data rating dari form
        $rating = $request->input('rating');
        $pengaduanId = $request->input('pengaduan_id');

        // Temukan pengaduan yang sesuai
        $pengaduan = Pengaduan::find($pengaduanId);

        // Periksa apakah pengaduan ditemukan
        if ($pengaduan) {
            // Update rating pengaduan
            $pengaduan->rating = $rating;
            $pengaduan->save();

            // Redirect atau tampilkan pesan sukses
            return redirect()->back()->with('success', 'Rating berhasil disimpan.');
        } else {
            // Jika pengaduan tidak ditemukan, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Pengaduan tidak ditemukan.');
        }
    }

}
