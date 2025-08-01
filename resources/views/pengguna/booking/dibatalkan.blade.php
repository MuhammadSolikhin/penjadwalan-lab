@extends('layouts.app')

@section('title', $page_meta['page'])
@vite(['resources/css/form-pengajuan.css'])

@section('content')
    <h2>{{ $page_meta['page'] }}</h2>
    <p>{{ $page_meta['description'] }}</p>
    <hr>
    @livewire('pengguna.booking.pengajuan-booking-table', ['status' => 'ditolak', 'currentRoute' => $path])
    @livewire('pengguna.booking.detail-pengajuan-booking')
@endsection