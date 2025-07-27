@php
    use Carbon\Carbon;
    App::setLocale('id');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/css/mystyle.css'])
</head>

<body>
    <div class="row align-items-center border-5 border-bottom border-dark">
        <div class="col-3"><img src="{{ asset('images/logo-reslab-square.png') }}" width="150px" alt=""
                srcset=""></div>
        <div class="col-6 text-center fs-3">
            YAYASAN SASMITA JAYA <br>
            <strong>UNIVERSITAS PAMULANG</strong> <br>
            RESLAB
        </div>
        <div class="col-3"><img src="{{ asset('images/logo-sasmita.png') }}" width="150px" alt=""
                srcset=""></div>
    </div>

    <h4 class="text-center pt-4">LAPORAN PENGGUNAAN LABORATORIUM</h4>

    <div class="mt-5">
        Periode : {{ Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d
        {{ Carbon::parse($endDate)->translatedFormat('d F Y') }}
    </div>

    <table class="table table-bordered">
        <thead>
            <th>No.</th>
            <th>Kode Booking</th>
            <th>Nama Pengguna</th>
            <th>Ruangan</th>
            <th>Lokasi</th>
            <th>Tanggal Penggunaan</th>
            <th>Tanggal Pengajuan</th>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($schedules as $schedule)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $schedule->kode_booking }}</td>
                    <td>{{ $schedule->user->nama_pengguna }}</td>
                    <td>
                        @php
                            $selectedLaboratory = $schedule->laboratorium->unique('nama_laboratorium');
                        @endphp

                        @foreach ($selectedLaboratory as $laboratory)
                            {{ $laboratory->nama_laboratorium }} @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td>{{$schedule->laboratorium->first()->lokasi->nama_lokasi}}</td>
                    <td>
                        @if ($schedule->mode_tanggal_pengajuan == 'range')
                            @php
                                $startDate = $schedule->jadwalBookings->first();
                                $endDate = $schedule->jadwalBookings->last();
                            @endphp
                            {{ Carbon::parse($startDate->tanggal_jadwal)->translatedFormat('d F Y') }} -
                            {{ Carbon::parse($endDate->tanggal_jadwal)->translatedFormat('d F Y') }}
                        @else
                            @php
                                $selectedSchedule = $schedule->jadwalBookings->unique('tanggal_jadwal');
                            @endphp

                            @foreach ($selectedSchedule as $selected)
                                {{ Carbon::parse($selected->tanggal_jadwal)->translatedFormat('d F Y') }} @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>{{ Carbon::parse($schedule->created_at)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
