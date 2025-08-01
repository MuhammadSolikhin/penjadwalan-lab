@extends('layouts.app')

@section('title', 'Laboratorium')

@section('content')
    @vite(['resources/js/laboran/laboratorium-page/laboratorium.js'])

    {{-- Laboratorium --}}
    @include('laboran.laboratorium-page.laboratorium.form-laboratorium-store')
    @include('laboran.laboratorium-page.laboratorium.form-laboratorium-detail')
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

    <script>
        let labTab = @json(session('tab')) ?? 'laboratorium';
        

        document.addEventListener('DOMContentLoaded', function() {
            function bukaTab(tabId) {
                const tabTrigger = document.querySelector(`#${tabId}`);
                if (tabTrigger) {
                    const labTab = new bootstrap.Tab(tabTrigger);
                    labTab.show();
                }
            }

            console.log(labTab);
            

            // Ambil nilai dari server via tab (dari Blade)
            const tabFromServer = labTab || 'laboratorium';

            const tabMap = {
                laboratorium: 'nav-laboratorium-tab',
                jenis: 'nav-jenis-laboratorium-tab',
            };

            if (tabMap[tabFromServer]) {
                bukaTab(tabMap[tabFromServer]);
            }
        });
    </script>
@endsection
