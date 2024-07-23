<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengaduansController extends Controller
{

    public function createPengaduan(Request $request)
    {
        try {
            try {
                $user = User::where('token', $request->bearerToken())->first();
            } catch (\Exception $e) {
                return response()->json(['errortoken' => $e->getMessage()], 500);
            }
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            try {
                $validatedData = $request->validate([
                    'description' => 'required',
                    'jenis_pengaduan' => 'required',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
            } catch (\Exception $e) {
                return response()->json(['errorvalidasi' => $e->getMessage()], 500);
            }
            $imageName = null;
            $imagePath = null;
            if ($request->hasFile('image')) {
                try {
                    $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                    $imagePath = 'assets/laporan/' . $imageName;
                    $request->file('image')->storeAs('assets/laporan', $imageName, 'public');
                } catch (\Exception $e) {
                    return response()->json(['errorfoto' => $e->getMessage()], 500);
                }
            }
            try {
                $pengaduan = new Pengaduan();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            try {
                $pengaduan->name = $user->name;
            } catch (\Exception $e) {
                return response()->json(['errornama' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->description = $validatedData['description'];
            } catch (\Exception $e) {
                return response()->json(['errordeskripsi' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->image = $imagePath;
            } catch (\Exception $e) {
                return response()->json(['errorfoto' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->jenis_pengaduan = $validatedData['jenis_pengaduan'];
            } catch (\Exception $e) {
                return response()->json(['errorjenis' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->user_nik = $user->nik;
            } catch (\Exception $e) {
                return response()->json(['errornik' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->user_id = $user->id;
            } catch (\Exception $e) {
                return response()->json(['errorid' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->status = 'Belum di Proses';
            } catch (\Exception $e) {
                return response()->json(['errorstatus' => $e->getMessage()], 500);
            }

            try {
                $pengaduan->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            // Tambahkan kode pengiriman pesan menggunakan cURL
            // $token = "zp8w3oWLTuwyktoWG#VP"; //token nomer Bisnis 
            $token = "bW8k!41+nHxDnsZQKsqW"; //token nomer asli
        
            // $target = "62895422399375, 6285161932152";
            $target = "6285161932152"; 
            $data = "PENGADUAN BARU TELAH DIBUAT\n- Nama : " . $user->name. "\n- Jenis : ". $pengaduan->jenis_pengaduan . 
            "\n- Deskripsi : ". $pengaduan->description;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => $data,
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return response()->json([
                'message' => 'Pengaduan created successfully',
                'data' => $pengaduan
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllPengaduan()
    {
        // Mendapatkan semua data dari tabel pengaduans
        $pengaduans = Pengaduan::all();

        // Jika tidak ada data ditemukan, kirimkan response error
        if ($pengaduans->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        return response()->json($pengaduans, 200);
    }

    public function getPengaduanById($id)
    {
        // Temukan pengaduan berdasarkan ID
        $pengaduan = Pengaduan::find($id);

        // Periksa apakah pengaduan ditemukan
        if (!$pengaduan) {
            return response()->json(['message' => 'Pengaduan not found'], 404);
        }

        // Konversi nilai-nilai ke boolean
        $responsivitas = (int) $pengaduan->responsivitas;
        $komunikasi = (int) $pengaduan->komunikasi;
        $sikap = (int) $pengaduan->sikap;
        $waktu = (int) $pengaduan->waktu;
        $pemahaman = (int) $pengaduan->pemahaman;

        // Jika ditemukan, kembalikan pengaduan bersama dengan informasi lainnya dalam respons JSON
        return response()->json([
            'id' => $pengaduan->id,
            'name' => $pengaduan->name,
            'user_nik' => $pengaduan->user_nik,
            'description' => $pengaduan->description,
            'jenis_pengaduan' => $pengaduan->jenis_pengaduan,
            'created_at' => $pengaduan->created_at,
            'image' => $pengaduan->image,
            'status' => $pengaduan->status,
            'rating' => $pengaduan->rating,
            'responsivitas' => $responsivitas,
            'komunikasi' => $komunikasi,
            'sikap' => $sikap,
            'waktu' => $waktu,
            'pemahaman' => $pemahaman,
            'desc_rating' => $pengaduan->desc_rating,
        ], 200);
    }

    public function getPengaduanByUserNik(Request $request)
    {
        // Mengambil NIK dari permintaan
        $nik = $request->user_nik;
    
        // Mendapatkan semua pengaduan berdasarkan NIK pengguna
        $pengaduans = Pengaduan::where('user_nik', $nik)->orderBy('created_at', 'desc')->get();
    
        // Jika tidak ada data ditemukan, kirimkan response error
        if ($pengaduans->isEmpty()) {
            return response()->json(['error' => 'No data found for this NIK'], 404);
        }
    
        return response()->json($pengaduans, 200);
    }

    public function getPengaduanByUserNikStatus($nik, Request $request)
    {
        $status = $request->query('status');
        $query = Pengaduan::where('user_nik', $nik);
        if (!empty($status)) {
            $query->where('status', $status);
        }
        $pengaduans = $query->orderBy('created_at', 'desc')->get();
        if ($pengaduans->isEmpty()) {
            return response()->json(['error' => 'No data found for this NIK and status'], 404);
        }
        return response()->json($pengaduans, 200);
    }
    
    public function getPengaduanByUserNikStatusTidakSelesai($nik)
    {
        $pengaduans = Pengaduan::where('user_nik', $nik)
                               ->where('status', '!=', 'selesai')
                               ->orderBy('created_at', 'desc')
                               ->get();
    
        if ($pengaduans->isEmpty()) {
            return response()->json(['error' => 'No data found for this NIK and status'], 404);
        }
    
        return response()->json($pengaduans, 200);
    }

    public function addRating(Request $request,$id)
    {
        // Temukan pengaduan berdasarkan ID
        $pengaduan = Pengaduan::find($id);

        // Periksa apakah pengaduan ditemukan
        if (!$pengaduan) {
            return response()->json(['message' => 'Pengaduan not found'], 404);
        }

        $rating = $request->input('rating');
        // Update rating pengaduan
        $pengaduan->rating = $rating;

        // Simpan perubahan ke database
        $pengaduan->save();

        return response()->json(['message' => 'Rating added successfully', 'data' => $pengaduan], 200);
    }

    // public function submitDetailRating(Request $request, $id)
    // {
    //     // Validasi request
    //     $request->validate([
    //         'responsivitas' => 'nullable|boolean',
    //         'komunikasi' => 'nullable|boolean',
    //         'sikap' => 'nullable|boolean',
    //         'waktu' => 'nullable|boolean',
    //         'pemahaman' => 'nullable|boolean',
    //         'desc_rating' => 'nullable|string',
    //     ]);

    //     // Temukan pengaduan yang sesuai
    //     $pengaduan = Pengaduan::find($id);

    //     // Periksa apakah pengaduan ditemukan
    //     if ($pengaduan) {
    //         // Update nilai pengaduan
    //         $pengaduan->responsivitas = $request->input('responsivitas', 0);
    //         $pengaduan->komunikasi = $request->input('komunikasi', 0);
    //         $pengaduan->sikap = $request->input('sikap', 0);
    //         $pengaduan->waktu = $request->input('waktu', 0);
    //         $pengaduan->pemahaman = $request->input('pemahaman', 0);
    //         $pengaduan->desc_rating = $request->input('desc_rating');
    //         $pengaduan->save();

    //         // Kembalikan respon sukses
    //         return response()->json(['message' => 'Detail rating berhasil disimpan.']);
    //     } else {
    //         // Jika pengaduan tidak ditemukan, kembalikan dengan pesan error
    //         return response()->json(['message' => 'Pengaduan tidak ditemukan.'], 404);
    //     }
    // }

    public function submitDetailRating(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'responsivitas' => 'required|integer|min:0|max:5',
            'komunikasi' => 'required|integer|min:0|max:5',
            'sikap' => 'required|integer|min:0|max:5',
            'waktu' => 'required|integer|min:0|max:5',
            'pemahaman' => 'required|integer|min:0|max:5',
            'desc_rating' => 'nullable|string',
        ]);

        // Temukan pengaduan yang sesuai
        $pengaduan = Pengaduan::find($id);

        // Periksa apakah pengaduan ditemukan
        if ($pengaduan) {
            // Update nilai pengaduan
            $pengaduan->responsivitas = $request->input('responsivitas');
            $pengaduan->komunikasi = $request->input('komunikasi');
            $pengaduan->sikap = $request->input('sikap');
            $pengaduan->waktu = $request->input('waktu');
            $pengaduan->pemahaman = $request->input('pemahaman');
            $pengaduan->desc_rating = $request->input('desc_rating');
            $pengaduan->save();

            // Kembalikan respon sukses
            return response()->json(['message' => 'Detail rating berhasil disimpan.']);
        } else {
            // Jika pengaduan tidak ditemukan, kembalikan dengan pesan error
            return response()->json(['message' => 'Pengaduan tidak ditemukan.'], 404);
        }
    }
}

