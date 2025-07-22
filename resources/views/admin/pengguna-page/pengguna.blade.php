@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    @vite(['resources/js/admin/pengguna-page/pengguna'])

    {{-- Pengguna --}}
    @include('admin.pengguna-page.pengguna.form-pengguna-store')
    @include('admin.pengguna-page.pengguna.form-pengguna-detail')
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

    {{-- <button id="btn-ke-peran" class="btn btn-primary mb-3">
        Buka Tab Peran
    </button> --}}

    <script>
        let tab = @json(session('tab')) ?? 'pengguna';
        

        document.addEventListener('DOMContentLoaded', function() {
            function bukaTab(tabId) {
                const tabTrigger = document.querySelector(`#${tabId}`);
                if (tabTrigger) {
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }

            console.log(tab);
            

            // Ambil nilai dari server via tab (dari Blade)
            const tabFromServer = tab || 'pengguna';

            const tabMap = {
                pengguna: 'nav-pengguna-tab',
                peran: 'nav-peran-tab',
                lokasi: 'nav-lokasi-tab'
            };

            if (tabMap[tabFromServer]) {
                bukaTab(tabMap[tabFromServer]);
            }
        });
    </script>

@endsection
