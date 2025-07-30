@extends('layouts.app')

@section('title', 'Booking Kalender')
@vite(['resources/css/form-pengajuan.css'])
@vite(['resources/js/pengguna/booking/form-pengajuan-booking.js'])
@vite(['resources/js/pengguna/booking/calendar.js'])

@section('content')
<div class="col-12">
    <h2>Reservasi</h2>
    <span>Halaman untuk melihat jadwal reservasi</span>
    <hr>

    @livewire('pengguna.booking.form-pengajuan-booking-create')

    <div id="calendar-container">
        <div id="calendar-loader" class="text-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="calendar" style="display: none;"></div>
    </div>
</div>
@endsection
