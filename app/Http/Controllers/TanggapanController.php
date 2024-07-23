<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function getTanggapanByPengaduanId($pengaduanId)
    {
        $tanggapan = Tanggapan::where('pengaduan_id', $pengaduanId)->get();
        return response()->json($tanggapan);
    }

    public function store(Request $request)
    { 
        $petugas_id = Auth::user()->id;        
        
        $pengaduan = DB::table('pengaduans')->where('id', $request->pengaduan_id);

        $updateData = [
            'status' => $request->status,
            'id_petugas' => $petugas_id,
        ];

        // If status is 'Selesai', set priority to 1
        if ($request->status === 'Selesai') {
            $updateData['prioritas'] = 0;
        }

        $pengaduan->update($updateData);
        
        $data = $request->all();

        $data['pengaduan_id'] = $request->pengaduan_id;
        $data['petugas_id']=$petugas_id;

        Tanggapan::create($data);
        Alert::success('Berhasil', 'Pengaduan berhasil ditanggapi');
        return redirect('admin/pengaduans');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $item = Pengaduan::with(['details', 'user' ])->findOrFail($id);

        return view('pages.admin.tanggapan.add', [
            'item' => $item,
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}