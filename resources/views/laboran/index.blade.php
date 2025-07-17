@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <p class="fw-bold fs-3">Selamat Datang, {{ Auth::user()->nama_pengguna }}</p>
    <p class="fs-6 mb-4">Ringkasan aktifitas penggunaan laboratorium komputer Universitas Pamulang</p>

    {{-- Summary Cards --}}
    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3 mt-4">
        {{-- Card One --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Komputer</p>
                <p class="fs-2 fw-bold">{{ $computerCount }}</p>
            </div>
        </div>
        {{-- Card Two --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Ruangan</p>
                <p class="fs-2 fw-bold">{{ $laboratoryCount }}</p>
            </div>
        </div>
        {{-- Card Three --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Jadwal</p>
                <p class="fs-2 fw-bold">{{ $schedulesCount }}</p>
            </div>
        </div>
        {{-- Card Four --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Pengguna</p>
                <p class="fs-2 fw-bold">{{ $usersCount }}</p>
            </div>
        </div>
    </div>

    {{-- Usage History Chart --}}
    <div class="bg-white rounded-3 m-4 p-5" style="position: relative;">
        <h4 class="fw-bold text-center p-3">Jumlah Jadwal 6 Periode Terakhir</h4>
        <canvas id="uHistoryChart"></canvas>
    </div>

    {{-- Building Chart --}}
    <div class="row bg-white rounded-3 m-4 p-4">
        <div class="col-12 col-md-4 text-center">
            <p class="fs-1 fw-bold">{{ $schedulesCount }}</h6>
            <p>Jumlah Keseluruhan Jadwal</p>
        </div>

        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                    <div class="d-flex justify-content-center align-items-center" style="position: relative; width:100px">
                        <canvas id="buildChart1"></canvas>
                        <p class="position-absolute fw-bold" style="top: 44px;">{{ $pusatCount }}</p>
                    </div>
                    <p>Gedung Pusat</p>
                </div>


                <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                    <div class="d-flex justify-content-center align-items-center" style="position: relative; width:100px">
                        <canvas id="buildChart2"></canvas>
                        <p class="position-absolute fw-bold" style="top: 44px;">{{ $witanaCount }}</p>
                    </div>
                    <p>Gedung Witana</p>
                </div>

                <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                    <div class="d-flex justify-content-center align-items-center" style="position: relative; width:100px">
                        <canvas id="buildChart3"></canvas>
                        <p class="position-absolute fw-bold" style="top: 44px;">{{ $viktorCount }}</p>
                    </div>
                    <p>Gedung Viktor</p>
                </div>

                <div class="col-6 col-md-3 d-flex flex-column align-items-center">
                    <div class="d-flex justify-content-center align-items-center" style="position: relative; width:100px">
                        <canvas id="buildChart4"></canvas>
                        <p class="position-absolute fw-bold" style="top: 44px;">{{ $serangCount }}</p>
                    </div>
                    <p>Unpam Serang</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Most Use & Room Status --}}
    <div class="row gap-3 m-4">
        <div class="col-12 col-lg bg-white rounded p-3">
            <div class="d-flex flex-column align-items-center text-center">
                <p class="fw-bold fs-5">Grafik peringkat<br>penggunaan terbanyak</p>
                <div class="position-relative d-flex justify-content-center align-items-center" style="width: 150px">
                    <canvas id="userRankChart"></canvas>
                    <p class="position-absolute fw-bold fs-3 text-center" style="top: 55px">
                        {{ $schedulesCount }}
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <ul class="text-start">
                    <?php
                    $i = 0;
                    $showedCount = 0;
                    $colors = ['rgb(174, 198, 207)', 'rgb(83, 83, 83)', 'rgb(162, 132, 94)', 'rgb(255, 179, 71)', 'rgb(255, 145, 155)', 'rgb(217, 217, 217)'];
                    foreach ($topFrequent as $user) {
                        echo "<li style='color : $colors[$i]'>
                                                                                                                                                                            <div class='row'>
                                                                                                                                                                                <div class='col'><p class='text-black'>$user->nama_pengguna</p></div>
                                                                                                                                                                                <div class='col col-2'><p class='text-black text-end'>$user->jadwal_bookings_count</p></div>
                                                                                                                                                                            </div>
                                                                                                                                                                        </li>";
                        $showedCount += $user->jadwal_bookings_count;
                        $i++;
                    }
                    
                    ?>

                    <li>
                        <div class='row'>
                            <div class='col'>
                                <p class='text-black'>Lain-lain</p>
                            </div>
                            <div class='col col-2'>
                                <p class='text-black text-end'>{{ $schedulesCount - $showedCount }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg bg-white rounded p-3">
            <div class="d-flex flex-column justify-content-center h-100">
                <div class="text-center">
                    <p class="fs-1 fw-bold">{{ $laboratoryCount }}</p>
                    <p class="fw-bold fs-5">Jumlah Ruangan</p>
                    <hr class="my-5">
                </div>

                <div class="d-flex align-items-center justify-content-around">
                    <div class="text-center">
                        <p class="fw-bold fs-3">{{ $laboratoryCount }}</p>
                        <p>Ruangan<br>Tersedia</p>
                    </div>

                    <div class="mx-3">
                        <div class="text-center">
                            <p class="fw-bold fs-3">0</p>
                            <p>Ruangan<br>Diperbaiki</p>
                        </div>
                    </div>

                    <div>
                        <div class="text-center">
                            <p class="fw-bold fs-3">0</p>
                            <p>Ruangan<br>Rusak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const schedulesbyPeriod = @json($schedulesbyPeriod);

            console.log(schedulesbyPeriod.labels);

            const ctxBar = document.getElementById('uHistoryChart').getContext('2d');
            // Usage History Chart
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: schedulesbyPeriod.labels,
                    datasets: [{
                        label: 'Jumlah Jadwal',
                        data: schedulesbyPeriod.data,
                        backgroundColor: [
                            'rgba(255, 234, 197, 0.8)',
                        ],
                        borderColor: [
                            'rgb(255, 159, 64)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Building Chart Config
            const buildName = ['Gedung Pusat', 'Gedung Witana', 'Gedung Viktor', 'Unpam Serang'];
            const temp = [{{ $pusatCount }}, {{ $witanaCount }}, {{ $viktorCount }}, {{ $serangCount }}];

            for (let i = 0; i < buildName.length; i++) {
                const ctxBuild = document.getElementById('buildChart' + (i + 1)).getContext('2d');

                const data = {
                    datasets: [{
                        label: buildName[i],
                        data: [temp[i], ({{ $schedulesCount }} - temp[i])],
                        backgroundColor: [
                            'rgb(96, 63, 38)',
                            'rgb(217, 217, 217)'
                        ],
                        hoverOffset: 4
                    }],
                };

                const config = {
                    type: 'doughnut',
                    data: data,
                    options: {
                        events: []
                    }
                };


                new Chart(ctxBuild, config);
            }

            // User Rank Chart
            const ctxURChart = document.getElementById('userRankChart').getContext('2d');

            const dataUR = {
                labels: [
                    `{{ $topFrequent[0]->nama_pengguna }}`,
                    `{{ $topFrequent[1]->nama_pengguna }}`,
                    `{{ $topFrequent[2]->nama_pengguna }}`,
                    `{{ $topFrequent[3]->nama_pengguna }}`,
                    `{{ $topFrequent[4]->nama_pengguna }}`,
                    'Lain-lain'
                ],
                datasets: [{
                    label: 'Penggunaan',
                    data: [{{ $topFrequent[0]->jadwal_bookings_count }},
                        {{ $topFrequent[1]->jadwal_bookings_count }},
                        {{ $topFrequent[2]->jadwal_bookings_count }},
                        {{ $topFrequent[3]->jadwal_bookings_count }},
                        {{ $topFrequent[4]->jadwal_bookings_count }},
                        {{ $schedulesCount - $showedCount }}
                    ],
                    backgroundColor: [
                        '{{ $colors[0] }}',
                        '{{ $colors[1] }}',
                        '{{ $colors[2] }}',
                        '{{ $colors[3] }}',
                        '{{ $colors[4] }}',
                        '{{ $colors[5] }}'
                    ],
                    hoverOffset: 4
                }],
            };

            const configUR = {
                type: 'doughnut',
                data: dataUR,
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                }
            };

            new Chart(ctxURChart, configUR);
        });
    </script>
@endsection
