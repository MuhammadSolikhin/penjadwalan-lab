@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
@vite(['resources/js/admin/pengguna-page/pengguna'])

{{-- Pengguna --}}
@include('admin.pengguna-page.pengguna.form-pengguna-store')
@include('admin.pengguna-page.pengguna.form-pengguna-update')
@include('admin.pengguna-page.pengguna.form-pengguna-soft-delete')

{{-- Peran --}}
@include('admin.pengguna-page.peran.form-peran-store')
@include('admin.pengguna-page.peran.form-peran-update')
@include('admin.pengguna-page.peran.form-peran-soft-delete')

{{-- Lokasi --}}
@include('admin.pengguna-page.lokasi.form-lokasi-store')
@include('admin.pengguna-page.lokasi.form-lokasi-update')
@include('admin.pengguna-page.lokasi.form-lokasi-soft-delete')

    <div>
        <h2 class="fw-bold fs-3">Manajemen Pengguna</h2>
        <span>Halaman untuk mengelola data pengguna</span>
        <hr>
        <div id="table-container">
            @include('admin.pengguna-page.navigasi-pengguna')
        </div>
    </div>
@endsection
