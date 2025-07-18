@extends('layouts.app')

@section('content')
    <div class="card overflow-hidden mx-auto border-0 shadow">
        <div class="row card-body p-0">
            <div class="col-12 col-md-4 d-flex justify-content-between flex-column text-center text-light p-4 mybg-brown">
                <div>
                    <img class="rounded-circle mb-3"
                        src="{{ asset('images/mascot-stand.png') }}" width="150px"
                        alt="">
                    <h3>{{ $user->nama_pengguna }}</h3>
                </div>

                <div>
                    <button class="btn btn-danger text-white"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                            <path fill-rule="evenodd"
                                d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                        </svg> Keluar</button>

                    <a href="{{ url('/') }}" class="btn btn-light"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                        </svg> Kembali</a>
                </div>
            </div>

            <div class="col-12 col-md-8 p-4">
                <div class="mb-3">
                    <h6 class="fw-bold">Email</h6>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Lokasi</h6>
                    <p class="text-muted mb-0">{{ $user->lokasi->nama_lokasi }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Unit</h6>
                    <p class="text-muted mb-0">{{ $user->unit->kode_unit }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Role</h6>
                    <p class="text-muted mb-0">{{ $user->role->nama_peran }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
