@extends('layouts.admin')

@section('title')
Detail Pengaduan
@endsection

@section('content')
<main class="h-full pb-16 overflow-y-auto">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">
      Detail Pengaduan
    </h2>


    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        @foreach($item->details as $ite)
        <div
          class="text-gray-800 text-sm font-semibold px-4 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:text-gray-400 ">

          <h2>Nama : {{ $ite->name }}</h2>
          <h2 class="mt-4">NIK : {{ $ite->user_nik }}</h2>
          <h2 class="mt-4">No Telepon : {{ $item->user->phone }}</h2>
          <h2 class="mt-4">Tanggal : {{ $ite->created_at->format('l, d F Y - H:i:s') }}</h2>
          <h2 class="mt-4">Jenis Pengaduan : {{ $ite->jenis_pengaduan }}</h2>
          <h2 class="mt-4">Status : 
            @if($item->status =='Belum di Proses')
            <span
                  class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:text-red-100 dark:bg-red-700">
                  {{ $item->status }}
            </span>
            @elseif ($item->status =='Sedang di Proses')
            <span
                  class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-md dark:text-white dark:bg-orange-600">
                  {{ $item->status }}
            </span>
            @else
            <span
              class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
              {{ $item->status }}
            </span>
            @endif
          </h2>
          <h2 class="mt-4">Ditangani oleh : {{ $petugas ? $petugas->name : 'Belum ditentukan' }}</h2>
          <h2 class="mt-4">Prioritas : 
            @if ($item->prioritas == 1)
                Rendah - ⚠️
            @elseif ($item->prioritas == 2)
                Sedang - ⚠️⚠️
            @elseif ($item->prioritas == 3)
                Penting - ⚠️⚠️⚠️
            @else
                ✅
            @endif
          </h2>
          <h2 class="mt-4">Rating (1 - 5) : 
              @if ($ite->rating == 1)
                  ⭐ - Buruk
              @elseif ($ite->rating == 2)
                  ⭐⭐ - Kurang Baik
              @elseif ($ite->rating == 3)
                  ⭐⭐⭐ - Baik
              @elseif ($ite->rating == 4)
                  ⭐⭐⭐⭐ - Cukup Baik
              @elseif ($ite->rating == 5)
                  ⭐⭐⭐⭐⭐ - Sangat Baik
              @else
                  Belum ada rating
              @endif
          </h2>
          <h2 class="mt-4">Komentar pegawai :
              @if($ite->desc_rating)
                  {{$ite->desc_rating}}
              @else
                  Tidak ada komentar
              @endif
          </h2>
          <div class="flex items-start mt-4">
              <h2 class="mr-4">Hal yang memuaskan :</h2>
              @if(!$ite->responsivitas && !$ite->komunikasi && !$ite->sikap && !$ite->waktu && !$ite->pemahaman)
                  <p class="text-red-500">Tidak ada rincian</p>
              @else
                  <div class="flex flex-wrap gap-2">
                      @if($ite->responsivitas)
                          <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Responsivitas</span>
                      @endif
                      @if($ite->komunikasi)
                          <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Komunikasi</span>
                      @endif
                      @if($ite->sikap)
                          <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Sikap Petugas</span>
                      @endif
                      @if($ite->waktu)
                          <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Waktu Penanganan</span>
                      @endif
                      @if($ite->pemahaman)
                          <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Pemahaman Permasalahan</span>
                      @endif
                  </div>
              @endif
          </div>
        </div>

        <div class="px-4 py-3 mb-8 flex text-gray-800 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="relative hidden mr-3  md:block dark:text-gray-400">
            <h1 class="text-center mb-8 font-semibold">Foto</h1>
            <img class=" h-32 w-35 " src="{{ Storage::url($item->image) }}" alt="" loading="lazy" />
          </div>
          <div class="text-center flex-1 dark:text-gray-400">
            <h1 class="mb-8 font-semibold">Keterangan</h1>
            <p class="text-gray-800 dark:text-gray-400">
              {{ $item->description}}
            </p>
          </div>
        </div>
        @endforeach
        @if( Auth::user()->roles == 'ADMIN')
        <div class="px-4 py-3 mb-8 flex bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
            <div class="text-center flex-1">
                <h1 class="mb-8 font-semibold">Prioritas</h1>
                <p class="text-gray-800 dark:text-gray-400">
                    <form action="{{ route('submit-prioritas') }}" method="POST">
                        @csrf
                        <label for="prioritas" class="block mb-2">Tingkat Prioritas Pengaduan ini</label>
                        <select name="prioritas" id="prioritas" class="border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-gray-300">
                          <option value="" disabled selected>Pilih Tingkat Prioritas</option>
                          <option value="1">Rendah - ⚠️</option>
                          <option value="2">Sedang - ⚠️⚠️</option>
                          <option value="3">Penting - ⚠️⚠️⚠️</option>
                        </select>
                        <input type="hidden" name="pengaduan_id" value="{{ $item->id }}">
                        <button type="submit" class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Submit</button>
                    </form>
                </p>
            </div>
        </div>
        <div class="px-4 py-3 mb-8 flex bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
            <div class="text-center flex-1">
                <h1 class="mb-8 font-semibold">Petugas yang menangani</h1>
                <p class="text-gray-800 dark:text-gray-400">
                    <form action="{{ route('submit-menangani') }}" method="POST">
                        @csrf
                        <label for="petugas_id" class="block mb-2">Pilih Petugas yang Menangani Pengaduan ini</label>
                        <select name="petugas_id" id="petugas_id" class="border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-gray-300">
                          <option value="" disabled selected>Pilih Petugas</option>
                          @foreach ($petugasList as $petugas)
                            <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                          @endforeach
                        </select>
                        <input type="hidden" name="pengaduan_id" value="{{ $item->id }}">
                        <button type="submit" class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Submit</button>
                    </form>
                </p>
            </div>
        </div>
        @endif
        <div class="px-4 py-3 mb-8 flex bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
            <div class="text-center flex-1">
                <h1 class="mb-8 font-semibold">Tanggapan</h1>
                <p class="text-gray-800 dark:text-gray-400">
                    @if (empty($tangap->tanggapan))
                        Belum ada tanggapan
                    @else
                    <div class="flex items-center justify-center">
                        <div class="max-w-max">
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Tanggal</th>
                                        <th class="px-4 py-2">Progress</th>
                                        <th class="px-4 py-2">Pukul</th>
                                        <th class="px-4 py-2">Ditanggapi oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tangap->where('pengaduan_id', $item->id)->orderBy('created_at', 'desc')->get() as $t)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $t->created_at->format('d/m/Y') }}</td>
                                            <td class="border px-4 py-2">{{ $t->tanggapan }}</td>
                                            <td class="border px-4 py-2">{{ $t->created_at->format('H:i') }}WIB</td>
                                            <td class="border px-4 py-2">{{ $t->petugas->name ?? 'Tidak Terdata' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </p>
            </div>
        </div>

      </div>
      <div class="flex justify-center my-4">
        <a href="{{ url('admin/pengaduan/cetak', $item->id)}}"
          class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          Export ke PDF
        </a>
      </div>
      <div class="flex justify-center my-6">
        <a href="{{ route('tanggapan.show', $item->id)}}"
          class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          Berikan Tanggapan
        </a>
      </div>
    </div>

</main>
@endsection