@extends('layouts.app')

@section('title', 'Laboratorium')

@section('content')
    @vite(['resources/js/laboran/laboratorium-page/laboratorium'])

    {{-- Laboratorium --}}
    @include('laboran.laboratorium-page.laboratorium.form-laboratorium-store')
    @include('laboran.laboratorium-page.laboratorium.form-laboratorium-update')
    @include('laboran.laboratorium-page.laboratorium.form-laboratorium-soft-delete')

    {{-- Jenis Laboratorium --}}
    @include('laboran.laboratorium-page.jenis-lab.form-jenis-lab-store')
    @include('laboran.laboratorium-page.jenis-lab.form-jenis-lab-update')
    @include('laboran.laboratorium-page.jenis-lab.form-jenis-lab-soft-delete')

    <div class="col-12">
        <h2 class="fw-bold">Manajemen Laboratorium</h2>
        <span>Halaman untuk mengelola data laboratorium yang dimiliki oleh Universitas Pamulang</span>
        <hr>

        <div id="table-container">
            @include('laboran.laboratorium-page.navigasi-laboratorium')
        </div>
    </div>
@endsection
