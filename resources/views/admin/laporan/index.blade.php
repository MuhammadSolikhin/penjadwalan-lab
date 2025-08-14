@extends('layouts.app')

@php
    use Carbon\Carbon;
    App::setLocale('id');
@endphp

@section('content')
    <h2 class="fw-bold fs-3">Laporan</h2>
    <span>Halaman untuk melihat mencetak data reservasi penggunaan laboratorium</span>
    <hr>

    <div class="row align-items-end mb-3">
        <div class="col-10">
            <label for="periode" class="form-label">Periode</label>
            <form action="{{ route('laporan.admin') }}" method="get" class="d-flex align-items-center gap-2">
                <div class="col-2">
                    <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                </div>
                -
                <div class="col-2">
                    <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                </div>

                <div class="col-2">
                    <button type="submit" class="mybtn mybtn-primary p-2 text-light rounded-1">Tampilkan</button>
                </div>
            </form>
        </div>

        <div class="col-2">
            <form action="{{ route('laporan.admin.cetak') }}" method="get" target="_blank">
                <div class="col text-end">
                    <input type="hidden" name="startDate" value="{{ request('startDate') }}">
                    <input type="hidden" name="endDate" value="{{ request('endDate') }}">
                    <button type="submit" class="btn btn-sm btn-dark text-light"><i data-feather="printer"
                            width="18px"></i> Cetak</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
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
                @if ($submissions->count() < 1)
                    <tr>
                        <td colspan="7" class="text-center text-secondary"><i>Belum ada data</i></td>
                    </tr>
                @endif

                <?php $i = 1; ?>
                @foreach ($submissions as $submission)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $submission->kode_booking }}</td>
                        <td>{{ $submission->user->nama_pengguna }}</td>
                        <td>
                            @php
                                $selectedLaboratory = $submission->laboratorium->unique('nama_laboratorium');
                            @endphp

                            @foreach ($selectedLaboratory as $laboratory)
                                {{ $laboratory->nama_laboratorium }} @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $submission->laboratorium->first()->lokasi->nama_lokasi }}</td>
                        <td>
                            @if ($submission->mode_tanggal_pengajuan == 'range')
                                @php
                                    $startDate = $submission->jadwalBookings->first();
                                    $endDate = $submission->jadwalBookings->last();
                                @endphp
                                {{ Carbon::parse($startDate->tanggal_jadwal)->translatedFormat('d F Y') }} -
                                {{ Carbon::parse($endDate->tanggal_jadwal)->translatedFormat('d F Y') }}
                            @else
                                @php
                                    $selectedSchedule = $submission->jadwalBookings->unique('tanggal_jadwal');
                                @endphp

                                @foreach ($selectedSchedule as $selected)
                                    {{ Carbon::parse($selected->tanggal_jadwal)->translatedFormat('d F Y') }} @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{ Carbon::parse($submission->created_at)->translatedFormat('d F Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
