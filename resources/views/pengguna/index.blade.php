@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <p class="fw-bold fs-3">Selamat Datang {{ auth()->user()->nama_pengguna }} !</p>
    <p class="fs-6 mb-4">Ringkasan aktifitas penggunaan laboratorium komputer Universitas Pamulang</p>

    {{-- Summary Cards --}}
    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3 mt-4">
        {{-- Card One --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Komputer</p>
                <p class="fs-2 fw-bold">512</p>
            </div>
        </div>
        {{-- Card Two --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Komputer</p>
                <p class="fs-2 fw-bold">43</p>
            </div>
        </div>
        {{-- Card Three --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jumlah Jadwal</p>
                <p class="fs-2 fw-bold">972</p>
            </div>
        </div>
        {{-- Card Four --}}
        <div class="col">
            <div class="bg-white rounded m-2 px-4 py-2">
                <p class="fw-medium mt-2">Jadwal Tersedia</p>
                <p class="fs-2 fw-bold">24</p>
            </div>
        </div>
    </div>

    {{-- Building Chart --}}
    <div class="d-flex align-items-center bg-white rounded-3 m-4 p-4">
        <div class="col-4 text-center">
            <p class="fs-1 fw-bold">556</h6>
            <p>Jumlah Keseluruhan Jadwal</p>
        </div>

        <div class="d-flex col-8 justify-content-around">
            <div>
                <div style="position: relative; width:100px">
                    <canvas id="buildChart1"></canvas>
                    <p class="position-absolute fw-bold" style="top: 44px; left: 38px">218</p>
                </div>
                <p>Gedung Pusat</p>
            </div>


            <div>
                <div style="position: relative; width:100px">
                    <canvas id="buildChart2"></canvas>
                    <p class="position-absolute fw-bold" style="top: 44px; left: 38px">252</p>
                </div>
                <p>Gedung Viktor</p>
            </div>

            <div>
                <div style="position: relative; width:100px">
                    <canvas id="buildChart3"></canvas>
                    <p class="position-absolute fw-bold" style="top: 44px; left: 38px">44</p>
                </div>
                <p>Gedung Witana</p>
            </div>

            <div>
                <div style="position: relative; width:100px">
                    <canvas id="buildChart4"></canvas>
                    <p class="position-absolute fw-bold" style="top: 44px; left: 38px">52</p>
                </div>
                <p>Unpam Serang</p>
            </div>
        </div>
    </div>

    {{-- Most Use & Room Status --}}
    <div class="d-flex m-4 gap-2 my-h500">
        <div class="col d-flex flex-column justify-content-center align-items-center bg-white rounded me-2 p-4">
            <p class="fw-bold fs-5 text-center">Grafik peringkat<br>penggunaan terbanyak</p>
            <div class="position-relative" style="width: 150px">
                <canvas id="userRankChart"></canvas>
                <p class="position-absolute fw-bold fs-3 text-center" style="top: 58px; left: 52px">514</p>
            </div>

            <div class="mt-4">
                <ol>
                    <li>Teknik Informatika</li>
                    <li>Teknik Elektro</li>
                    <li>Lembaga Bahasa</li>
                    <li>Lembaga Sertifikasi profesi</li>
                    <li>Lain-lain</li>
                </ol>
            </div>
        </div>

        {{-- Submission Table --}}
        <div class="col bg-white rounded-3 my-h500">
            <h6 class="fs-4 fw-medium mybg-brown100 rounded-top-3 p-3">Status Pengajuan</h6>

            <div class="px-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No. Pengajuan</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Hari</th>
                            <th class="text-center" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TEKSNAFE</td>
                            <td>CBT1,CBT2</td>
                            <td>Kamis</td>
                            <td class="text-center">
                                <p class="p-1 rounded-2 bg-warning fw-bold myfs-1">Menunggu</p>
                            </td>
                        </tr>
                        <tr>
                            <td>ABSAFEIO</td>
                            <td>773</td>
                            <td>Senin</td>
                            <td class="text-center">
                                <p class="p-1 rounded-2 bg-success text-light fw-bold myfs-1">Diterima</p>
                            </td>
                        </tr>
                        <tr>
                            <td>PSENFAIY</td>
                            <td>782</td>
                            <td>Sabtu</td>
                            <td class="text-center">
                                <p class="p-1 rounded-2 bg-danger text-light fw-bold myfs-1">Ditolak</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Building Chart Config
            const buildName = ['Gedung Pusat', 'Gedung Viktor', 'Gedung Witana', 'Unpam Serang'];
            const temp = [218, 252, 44, 52];

            for (let i = 0; i < buildName.length; i++) {
                const ctxBuild = document.getElementById('buildChart' + (i + 1));

                const data = {
                    datasets: [{
                        label: buildName[i],
                        data: [temp[i], (556 - temp[i])],
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
            const ctxURChart = document.getElementById('userRankChart');

            const dataUR = {
                labels: [
                    'Teknik Informatika',
                    'Teknik Elektro',
                    'Lembaga Bahasa',
                    'Lembaga Sertifikasi Profesi',
                    'Lain-lain'
                ],
                datasets: [{
                    label: 'Penggunaan',
                    data: [500, 300, 250, 140, 100],
                    backgroundColor: [
                        'rgb(174, 198, 207)',
                        'rgb(217, 217, 217)',
                        'rgb(162, 132, 94)',
                        'rgb(255, 179, 71)',
                        'rgb(255, 145, 155)'
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
