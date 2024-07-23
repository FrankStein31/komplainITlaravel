@extends('layouts.admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@section('title')
Data Rating
@endsection

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Data Rating Petugas
        </h2>

        <!-- Tabel Rating -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Rank</th>
                            <!-- <th class="px-4 py-3">ID</th> -->
                            <th class="px-4 py-3">Nama Petugas</th>
                            <th class="px-4 py-3">Bidang</th>
                            <th class="px-4 py-3">Jumlah Pengaduan</th>
                            <th class="px-4 py-3">Rata-rata Rating</th>
                            <th class="px-4 py-3">Responsivitas</th>
                            <th class="px-4 py-3">Sikap Petugas</th>
                            <th class="px-4 py-3">Komunikasi</th>
                            <th class="px-4 py-3">Waktu Penanganan</th>
                            <th class="px-4 py-3">Pemahaman Permasalahan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($ratingPetugas as $index => $rating)
                        <tr class="text-gray-700 dark:text-gray-400 {{ $index < 3 ? 'font-bold' : '' }}">
                            <td class="px-4 py-3">
                                {{ $index + 1 }}
                                @if($index == 0)
                                    <svg class="inline-block w-8 h-8 ml-2" viewBox="0 0 24 24">
                                        <path fill="#FFD700" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @elseif($index == 1)
                                    <svg class="inline-block w-8 h-8 ml-2" viewBox="0 0 24 24">
                                        <path fill="#C0C0C0" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @elseif($index == 2)
                                    <svg class="inline-block w-8 h-8 ml-2" viewBox="0 0 24 24">
                                        <path fill="#CD7F32" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $rating->name }}</td>
                            <td class="px-4 py-3">{{ $rating->bidang }}</td>
                            <td class="px-4 py-3">{{ $rating->jumlah_pengaduan }}</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_rating, 2) }}</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_responsivitas * 20, 2) }}%</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_sikap * 20, 2) }}%</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_komunikasi * 20, 2) }}%</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_waktu * 20, 2) }}%</td>
                            <td class="px-4 py-3">{{ number_format($rating->avg_pemahaman * 20, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- rating per bidang -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Rata-rata rating per Bidang</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 mb-8">
                <div class="w-full sm:w-2/3">
                    <label for="bidang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Bidang
                    </label>
                    <div class="relative">
                        <select id="bidang" name="bidang" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua Bidang</option>
                            <option value="Aplikasi">Aplikasi</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Perangkat">Perangkat</option>
                        </select>
                    </div>
                </div>
                <div class="w-full sm:w-1/3 flex items-end">
                    <button onclick="filterGrafik()" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <i class="fas fa-search"></i>Tampilkan
                    </button>
                </div>
            </div>
            <div id="chart-line" style="height: 400px;"></div>
        </div>
        <!-- Rating per Petugas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Rata-rata rating per Petugas</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 mb-8">
                <div class="w-full sm:w-2/3">
                    <label for="bidang_petugas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Bidang
                    </label>
                    <div class="relative">
                        <select id="bidang_petugas" name="bidang_petugas" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua Bidang</option>
                            <option value="Aplikasi">Aplikasi</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Perangkat">Perangkat</option>
                        </select>
                    </div>
                </div>
                <div class="w-full sm:w-1/3 flex items-end">
                    <button onclick="filterGrafikpetugas()" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <i class="fas fa-search"></i>Tampilkan
                    </button>
                </div>
            </div>
            <div id="chart-petugas" style="height: 400px;"></div>
        </div>

        <!-- Detail Rating per Petugas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Detail rata-rata rating per Petugas</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 mb-8">
                <div class="w-full sm:w-2/3">
                    <label for="bidang_detail_petugas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Bidang
                    </label>
                    <div class="relative">
                        <select id="bidang_detail_petugas" name="bidang_detail_petugas" class="block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua Bidang</option>
                            <option value="Aplikasi">Aplikasi</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Perangkat">Perangkat</option>
                        </select>
                    </div>
                </div>
                <div class="w-full sm:w-1/3 flex items-end">
                    <button onclick="filterGrafikdetailpetugas()" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <i class="fas fa-search"></i>Tampilkan
                    </button>
                </div>
            </div>
            <div id="chart-detail-petugas" style="height: 400px;"></div>
        </div>

    </div>
</main>
@endsection

<script>
    var curbidang = '';
    var chart = null;
    var chartPetugas = null;
    var chartDetailPetugas = null;
    // var ratingPerPetugas = {!! json_encode($ratingPerPetugas ?? []) !!};
    // var detailRatingPerPetugas = {!! json_encode($detailRatingPerPetugas ?? []) !!};

    var ratingPerPetugas = JSON.parse('{!! addslashes($ratingPerPetugas) !!}');
    var detailRatingPerPetugas = JSON.parse('{!! addslashes($detailRatingPerPetugas) !!}');

    function filterGrafik() {
        let bidang = $('#bidang').val();
        get_chartBidang(bidang);
    }

    function filterGrafikpetugas() {
        let bidang = $('#bidang_petugas').val();
        get_chartPetugas(bidang);
    }

    function filterGrafikdetailpetugas() {
        let bidang = $('#bidang_detail_petugas').val();
        get_chartDetailPetugas(bidang);
    }

    $(document).ready(function() {
        get_chartBidang();
        get_chartPetugas();
        get_chartDetailPetugas();
        // chartRatingPerPetugas();
        // chartDetailRatingPerPetugas();
    });
    
    function get_chartPetugas(bidangpetugas = '') {
        let url_submit = "{{ route('chartPetugas') }}";
        $.ajax({
            type: 'GET',
            url: url_submit,
            data: {
                "bidang": bidangpetugas,
            },
            success: function(data) {
                let ratingPerPetugas = data.ratingPerPetugas;
                chart_rating_per_petugas(ratingPerPetugas);
            },
            error: function(data) {
                alert('Terjadi Kesalahan Pada Server');
            },
        });
    }

    function get_chartDetailPetugas(bidangdetail = '') {
        let url_submit = "{{ route('chartDetailPetugas') }}";
        $.ajax({
            type: 'GET',
            url: url_submit,
            data: {
                "bidang": bidangdetail,
            },
            success: function(data) {
                let detailRatingPerPetugas = data.detailRatingPerPetugas;
                chart_detail_rating_per_petugas(detailRatingPerPetugas);
            },
            error: function(data) {
                alert('Terjadi Kesalahan Pada Server');
            },
        });
    }

    function get_chartBidang(bidang = curbidang) {
        let url_submit = "{{ route('chartBidang') }}";
        $.ajax({
            type: 'GET',
            url: url_submit,
            data: {
                "bidang": bidang,
            },
            success: function(data) {
                let ratings = data.ratings;
                let jenis_pengaduan = Object.keys(ratings);
                let ratingValues = Object.values(ratings);
                chart_rating_per_jenis_pengaduan(jenis_pengaduan, ratingValues);
            },
            error: function(data) {
                alert('Terjadi Kesalahan Pada Server');
            },
        });
    }

    function chart_rating_per_jenis_pengaduan(jenis_pengaduan, ratingValues) {
        var options = {
            series: [{
                name: 'Rata-rata',
                data: ratingValues
            }],
            chart: {
                type: 'bar',
                height: 360
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: jenis_pengaduan,
                title: {
                    text: 'Bidang'
                }
            },
            yaxis: {
                title: {
                    text: 'Rating'
                },
                labels: {
                    formatter: function(val) {
                        return val.toFixed(1);
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2);
                    }
                }
            }
        };

        if (chart) {
            chart.destroy();
        }
        chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();
    }

    function chart_rating_per_petugas(ratingPerPetugas) {
        var options = {
            series: [{
                name: 'Rating',
                data: ratingPerPetugas.map(item => item.average_rating)
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ratingPerPetugas.map(item => item.nama_petugas),
                title: {
                    text: 'Nama Petugas'
                }
            },
            yaxis: {
                title: {
                    text: 'Rating'
                },
                max: 5
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2)
                    }
                }
            }
        };

        if (chartPetugas) {
            chartPetugas.destroy();
        }
        chartPetugas = new ApexCharts(document.querySelector("#chart-petugas"), options);
        chartPetugas.render();
    }

    // function chartRatingPerPetugas() {
    //     var options = {
    //         series: [{
    //             name: 'Rating',
    //             data: ratingPerPetugas.map(item => item.average_rating)
    //         }],
    //         chart: {
    //             type: 'bar',
    //             height: 350
    //         },
    //         plotOptions: {
    //             bar: {
    //                 horizontal: false,
    //                 columnWidth: '55%',
    //                 endingShape: 'rounded'
    //             },
    //         },
    //         dataLabels: {
    //             enabled: false
    //         },
    //         xaxis: {
    //             categories: ratingPerPetugas.map(item => item.nama_petugas),
    //             title: {
    //                 text: 'Nama Petugas'
    //             }
    //         },
    //         yaxis: {
    //             title: {
    //                 text: 'Rating'
    //             },
    //             max: 5
    //         },
    //         fill: {
    //             opacity: 1
    //         },
    //         tooltip: {
    //             y: {
    //                 formatter: function (val) {
    //                     return val.toFixed(2)
    //                 }
    //             }
    //         }
    //     };

    //     var chart = new ApexCharts(document.querySelector("#chart-petugas"), options);
    //     chart.render();
    // }

    function chart_detail_rating_per_petugas(detailRatingPerPetugas) {
        var options = {
            series: [{
                name: 'Responsivitas',
                data: detailRatingPerPetugas.map(item => item.avg_responsivitas)
            }, {
                name: 'Komunikasi',
                data: detailRatingPerPetugas.map(item => item.avg_komunikasi)
            }, {
                name: 'Sikap Petugas',
                data: detailRatingPerPetugas.map(item => item.avg_sikap)
            }, {
                name: 'Waktu Penanganan',
                data: detailRatingPerPetugas.map(item => item.avg_waktu)
            }, {
                name: 'Pemahaman Permasalahan',
                data: detailRatingPerPetugas.map(item => item.avg_pemahaman)
            }],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: detailRatingPerPetugas.map(item => item.nama_petugas),
                labels: {
                    formatter: function (val) {
                        return val.toFixed(2)
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Nama Petugas'
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2)
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            }
        };

        if (chartDetailPetugas) {
            chartDetailPetugas.destroy();
        }
        chartDetailPetugas = new ApexCharts(document.querySelector("#chart-detail-petugas"), options);
        chartDetailPetugas.render();
    }

    // function chartDetailRatingPerPetugas() {
    //     var options = {
    //         series: [{
    //             name: 'Responsivitas',
    //             data: detailRatingPerPetugas.map(item => item.avg_responsivitas)
    //         }, {
    //             name: 'Komunikasi',
    //             data: detailRatingPerPetugas.map(item => item.avg_komunikasi)
    //         }, {
    //             name: 'Sikap Petugas',
    //             data: detailRatingPerPetugas.map(item => item.avg_sikap)
    //         }, {
    //             name: 'Waktu Penanganan',
    //             data: detailRatingPerPetugas.map(item => item.avg_waktu)
    //         }, {
    //             name: 'Pemahaman Permasalahan',
    //             data: detailRatingPerPetugas.map(item => item.avg_pemahaman)
    //         }],
    //         chart: {
    //             type: 'bar',
    //             height: 350,
    //             stacked: true,
    //         },
    //         plotOptions: {
    //             bar: {
    //                 horizontal: true,
    //             },
    //         },
    //         stroke: {
    //             width: 1,
    //             colors: ['#fff']
    //         },
    //         xaxis: {
    //             categories: detailRatingPerPetugas.map(item => item.nama_petugas),
    //             labels: {
    //                 formatter: function (val) {
    //                     return val.toFixed(2)
    //                 }
    //             }
    //         },
    //         yaxis: {
    //             title: {
    //                 text: 'Nama Petugas'
    //             },
    //         },
    //         tooltip: {
    //             y: {
    //                 formatter: function (val) {
    //                     return val.toFixed(2)
    //                 }
    //             }
    //         },
    //         fill: {
    //             opacity: 1
    //         },
    //         legend: {
    //             position: 'top',
    //             horizontalAlign: 'left',
    //             offsetX: 40
    //         }
    //     };

    //     var chart = new ApexCharts(document.querySelector("#chart-detail-petugas"), options);
    //     chart.render();
    // }

</script>


