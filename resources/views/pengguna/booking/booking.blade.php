@extends('layouts.app')

@section('title', 'Pengajuan')
@vite(['resources/js/pengguna/booking/form-pengajuan-booking.js'])

@section('content')
    <div class="col-12">
        <h2>Reservasi</h2>
        <span>Halaman untuk melakukan dan mengelola pengajuan yang ada</span>
        <hr>

        @livewire('pengguna.booking.form-pengajuan-booking-create')
        @livewire('pengguna.booking.pengajuan-booking-table')
        @livewire('pengguna.booking.form-pengajuan-booking-edit')
        @livewire('pengguna.booking.detail-pengajuan-booking')
        @livewire('pengguna.booking.batalkan-pengajuan-booking')
    </div>
@endsection 
