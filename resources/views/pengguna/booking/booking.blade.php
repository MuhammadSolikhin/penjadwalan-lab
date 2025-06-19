@extends('layouts.app')

@section('title', 'Pengajuan')
@vite(['resources/js/pengguna/booking/form-pengajuan-booking.js'])
@vite(['resources/js/pengguna/booking/calendar.js'])

@section('content')
    <div class="col-12 p-3 py-4">
        <h2>{{ $page_meta['page'] }}</h2>
        <span>{{ $page_meta['description'] }}</span>
        <hr>

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-3" id="pengajuanTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="table-tab" data-bs-toggle="tab" data-bs-target="#tablePane"
                    type="button" role="tab">
                    Tabel Pengajuan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendarPane" type="button"
                    role="tab">
                    Kalender
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="pengajuanTabContent">
            {{-- Calendar Tab --}}
            <div class="tab-pane fade" id="calendarPane" role="tabpanel">
                <div class="d-flex justify-content-end mb-3 mt-3" style="gap: 10px">
                    <button class="btn btn-success" onclick="exportEventsToExcel()">Export ke Excel</button>
                    <button class="btn btn-danger" onclick="exportCalendarToPDF()">Export ke PDF</button>
                </div>
                <div id="calendar-container">
                    <div id="calendar-loader" class="text-center my-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="calendar" style="display: none;"></div>
                </div>

            </div>

            {{-- Table Tab --}}
            <div class="tab-pane fade show active" id="tablePane" role="tabpanel">
                <div class="mt-3">
                    @livewire('pengguna.booking.form-pengajuan-booking-create')
                    @livewire('pengguna.booking.pengajuan-booking-table')
                </div>
            </div>
        </div>

        {{-- Komponen tambahan di luar tab --}}
        @livewire('pengguna.booking.form-pengajuan-booking-edit')
        @livewire('pengguna.booking.detail-pengajuan-booking')
        @livewire('pengguna.booking.batalkan-pengajuan-booking')
    </div>
@endsection