<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User; 
use RealRashid\SweetAlert\Facades\Alert;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Pengaduan::orderBy('prioritas', 'DESC')
                        ->orderBy('created_at', 'DESC')
                        ->get();

        return view('pages.admin.pengaduan.index', [
            'items' => $items
        ]);
    }

    public function submitPrioritas(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduans,id',
            'prioritas' => 'required|integer|min:1|max:3',
        ]);

        $pengaduan = Pengaduan::find($request->pengaduan_id);
        $pengaduan->prioritas = $request->prioritas;
        $pengaduan->save();

        return redirect()->back()->with('success', 'Prioritas berhasil diperbarui');
    }

    public function submitMenangani(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduans,id',
            'petugas_id' => 'required|exists:users,id',
        ]);

        $pengaduan = Pengaduan::find($request->pengaduan_id);
        $pengaduan->id_petugas = $request->petugas_id;
        $pengaduan->save();

        return redirect()->back()->with('success', 'Petugas yang menangani berhasil diperbarui');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $item = Pengaduan::with(['details', 'user'])->findOrFail($id);
        $petugas = User::where('id', $item->id_petugas)->first(); 
        $tangap = Tanggapan::where('pengaduan_id', $id)->first();
        $petugasList = User::where('bidang', $item->jenis_pengaduan)->get();

        return view('pages.admin.pengaduan.detail', [
            'item' => $item,
            'petugas' => $petugas,
            'tangap' => $tangap,
            'petugasList' => $petugasList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $status->update($data);
        // return redirect('admin/pengaduans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::find($id);
        $pengaduan->delete();

        Alert::success('Berhasil', 'Pengaduan telah di hapus');
        return redirect('admin/pengaduans');
    }
}
