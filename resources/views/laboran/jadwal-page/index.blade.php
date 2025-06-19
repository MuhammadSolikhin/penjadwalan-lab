@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Jadwal Penggunaan')

@section('content')
    <div class="my-3 mx-2">
        <div class="d-flex justify-content-between align-items-center">
            <p class="fw-bold fs-3">Jadwal Penggunaan</p>
            <nav>
                <a href="#">Home</a> / <a href="#">Jadwal</a> / <a class="fw-bold"
                    style="color: rgba(111, 78, 55, 1) !important;" href="#">Penggunaan</a>
            </nav>
        </div>

        <!-- Alert -->
        <x-validation></x-validation>


        <table class="table">
            <thead>
                <tr>
                    <th class="mybg-brown100">GEDUNG</th>
                    <th class="mybg-brown100">ALAMAT GEDUNG</th>
                    <th class="mybg-brown100 text-center">PILIHAN</th>
                </tr>
            </thead>

            <tr>
                <td>Pusat</td>
                <td>Jl. Bunderan</td>
                <td class="text-center">
                    <a href="" class="btn btn-secondary text-light">Lihat Jadwal</a>
                </td>
            </tr>

            <tr>
                <td>Viktor</td>
                <td>Jl. Raya Puspiptek</td>
                <td class="text-center">
                    <a href="#" class="btn btn-secondary text-light">Lihat Jadwal</a>
                </td>
            </tr>

            <tr>
                <td>Witana Harja</td>
                <td>Jl. Witana</td>
                <td class="text-center"><a href="#" class="btn btn-secondary text-light">Lihat Jadwal</a></td>
            </tr>
        </table>

    </div>
=======
@section('title', 'Jadwal')

@section('content')
    <h1 class="fw-bold text-uppercase">{{ $page_meta['page'] }}</h1>
    <hr>

    <!-- Alert -->
     <x-validation></x-validation>


     <div class="col-12 pb-3">
        @include('laboran.jadwal-page.generate-jadwal.datatables-generate-jadwal')
     </div>

     <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div class="col-12 col-md-5">
            @include('laboran.jadwal-page.pengajuan.datatables-pengajuan')
        </div>
        <div class="col-12 col-md-6">
            @include('laboran.jadwal-page.booking-log.datatables-booking-log')
        </div>
     </div>

     @include('laboran.jadwal-page.pengajuan.datatables-pengajuan-terima-modal')
     @include('laboran.jadwal-page.pengajuan.datatables-pengajuan-tolak-modal')
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

@endsection
