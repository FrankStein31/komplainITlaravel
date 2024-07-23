@extends('layouts.masyarakat')

@section('title')
Dashboard
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
        <h2 class="mt-4">Rating (1 - 5) : 
            @if ($ite->rating == 1)
                &#9733; - Buruk
            @elseif ($ite->rating == 2)
                &#9733;&#9733; - Kurang Baik
            @elseif ($ite->rating == 3)
                &#9733;&#9733;&#9733; - Baik
            @elseif ($ite->rating == 4)
                &#9733;&#9733;&#9733;&#9733; - Cukup Baik
            @elseif ($ite->rating == 5)
                &#9733;&#9733;&#9733;&#9733;&#9733; - Sangat Baik
            @endif
        </h2>

        
        </div>

        <div class="px-4 py-3 mb-8 flex text-gray-800 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="relative hidden mr-3  md:block ">
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
                                        <th class="px-4 py-2">Progress</th>
                                        <th class="px-4 py-2">Pukul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tangap->where('pengaduan_id', $item->id)->get() as $t)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $t->tanggapan }}</td>
                                            <td class="border px-4 py-2">{{ $t->created_at }}</td>
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

        <div class="px-4 py-3 mb-8 flex bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
            <div class="text-center flex-1">
                <h1 class="mb-8 font-semibold">Rating</h1>
                <p class="text-gray-800 dark:text-gray-400">
                    <form action="{{ route('submit-rating') }}" method="POST">
                        @csrf
                        <label for="rating" class="block mb-2">Beri rating terhadap penanganannya</label>
                        <select name="rating" id="rating" class="border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-gray-300">
                          <option value="" disabled selected>Beri rating terbaikmu</option>
                          <option value="1">&#9733;</option>
                          <option value="2">&#9733;&#9733;</option>
                          <option value="3">&#9733;&#9733;&#9733;</option>
                          <option value="4">&#9733;&#9733;&#9733;&#9733;</option>
                          <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                        </select>
                        <input type="hidden" name="pengaduan_id" value="{{ $item->id }}">
                        <button type="submit" class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Submit</button>
                    </form>
                </p>
            </div>
        </div>

      </div>
    </div>
</main>
@endsection