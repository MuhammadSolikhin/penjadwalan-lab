<div class="sidebar mybg-brown100 shadow py-5 px-4" id="sidebar">
    <div class="brand-logo gap-2 d-flex align-items-center justify-content-center">
        <!--img src="{{ asset('images/logo-reslab-full.png') }}" width="200px" alt="" srcset="" -->
    </div>


    <div class="m-4"></div>

    <ul class="menu-container list-unstyled">

        @php
            $userRole = auth()->user()->role->nama_peran;
            $dashboardRoute = in_array($userRole, ['admin', 'laboran']) ? $userRole . '.dashboard' : 'dashboard';
        @endphp
        <li
            class="sidebar-item pb-2 px-3 rounded-3 {{ Route::is($dashboardRoute) ? 'mybg-brown active' : 'mybg-brown200' }}">
            <a href="{{ route($dashboardRoute) }}"
                class="sidebar-link {{ Route::is($dashboardRoute) ? 'text-light' : '' }}">
                <img src="{{ Route::is($dashboardRoute) ? asset('images/icons/home.png') : asset('images/icons/home-black.png') }}"
                    class="mb-1 me-2" width="20px" alt="">Beranda
            </a>
        </li>

        @php
            $manajemenRoutes = ['admin.pengguna', 'laboran.laboratorium', 'admin.barang'];
            $isManajemenActive = in_array(Route::currentRouteName(), $manajemenRoutes);
        @endphp

        @if (in_array($userRole, ['admin', 'laboran']))
            <li
                class="sidebar-item pb-2 px-3 rounded-3 mt-2 {{ $isManajemenActive ? 'mybg-brown active' : 'mybg-brown200' }}">
                <a href="#"
                    class="sidebar-link d-flex flex-grow collapsed {{ $isManajemenActive ? 'text-light' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#manajemenDropdown">
                    <i data-feather="command" class="sidebar-icon-link"></i>Manajemen
                    <i data-feather="chevron-right" class="dropdown-icon {{ $isManajemenActive ? 'active' : '' }}"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isManajemenActive ? 'active' : '' }}"
                    id="manajemenDropdown">
                    @if ($userRole === 'admin')
                        <li class="sidebar-item {{ Route::is('admin.pengguna') ? 'active' : '' }}">
                            <a href="{{ route('admin.pengguna') }}"
                                class="sidebar-link {{ $isManajemenActive ? 'text-light' : '' }}">Pengguna</a>
                        </li>
                    @endif
                    <li class="sidebar-item {{ Route::is('laboran.laboratorium') ? 'active' : '' }}">
                        <a href="{{ route('laboran.laboratorium') }}"
                            class="sidebar-link {{ $isManajemenActive ? 'text-light' : '' }}">Laboratorium</a>
                    </li>
                </ul>
            </li>
        @endif

        @php
            $isBookingActive =
                Route::is('proses-pengajuan*') || Route::is('booking*') || Route::is('laboran.proses-pengajuan*');
        @endphp

        <li
            class="sidebar-item pb-2 px-3 rounded-3 mt-2 {{ $isBookingActive ? 'mybg-brown active' : 'mybg-brown200' }}">
            <a href="#"
                class="sidebar-link d-flex flex-grow collapsed {{ $isBookingActive ? 'text-light' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#bookingDropdown">
                <i data-feather="calendar" class="sidebar-icon-link"></i>Booking
                <i data-feather="chevron-right" class="dropdown-icon {{ $isBookingActive ? 'active' : '' }}"></i>
            </a>

            <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isBookingActive ? 'active' : '' }}"
                id="bookingDropdown">

                @if ($userRole !== 'laboran')
                    {{-- <li class="sidebar-item {{ Route::is('pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('pengajuan') }}" class="sidebar-link">Pengajuan</a>
                    </li> --}}

                    <li class="sidebar-item {{ Route::is('booking.index') ? 'active' : '' }}">
                        <a href="{{ route('booking.index') }}"
                            class="sidebar-link {{ Route::is('booking.index') ? 'text-light' : '' }}">
                            <i class="fa fa-calendar"></i> Kalender
                        </a>
                    </li>

                    <li class="sidebar-item {{ Route::is('booking.diterima') ? 'active' : '' }}">
                        <a href="{{ route('booking.diterima') }}"
                            class="sidebar-link {{ Route::is('booking.diterima') ? 'text-light' : '' }}">
                            <i class="fa fa-check-circle text-success"></i> Data Diterima
                        </a>
                    </li>

                    <li class="sidebar-item {{ Route::is('booking.menunggu') ? 'active' : '' }}">
                        <a href="{{ route('booking.menunggu') }}"
                            class="sidebar-link {{ Route::is('booking.menunggu') ? 'text-light' : '' }}">
                            <i class="fa fa-clock text-warning"></i> Data Menunggu
                        </a>
                    </li>

                    <li class="sidebar-item {{ Route::is('booking.dibatalkan') ? 'active' : '' }}">
                        <a href="{{ route('booking.dibatalkan') }}"
                            class="sidebar-link {{ Route::is('booking.dibatalkan') ? 'text-light' : '' }}">
                            <i class="fa fa-times-circle text-danger"></i> Data Dibatalkan
                        </a>
                    </li>
                @endif


                @if ($userRole == 'laboran' || $userRole == 'admin')
                    <li class="sidebar-item {{ Route::is('proses-pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('proses-pengajuan.index') }}"
                            class="sidebar-link {{ $isBookingActive ? 'text-light' : '' }}">Proses Pengajuan</a>
                    </li>
                @endif
            </ul>
        </li>

        @php
            $isBarangActive = Route::is('kategori-barang.*') || Route::is('barang.*');
        @endphp

        @if ($userRole == 'admin' || $userRole == 'laboran')
            <li
                class="sidebar-item pb-2 px-3 rounded-3 mt-2 {{ $isBarangActive ? 'mybg-brown active' : 'mybg-brown200' }}">
                <a href="#"
                    class="sidebar-link d-flex flex-grow collapsed {{ $isBarangActive ? 'text-light' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#barangDropdown">
                    <i data-feather="box" class="sidebar-icon-link"></i>Barang
                    <i data-feather="chevron-right" class="dropdown-icon {{ $isBarangActive ? 'active' : '' }}"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isBarangActive ? 'active' : '' }}"
                    id="barangDropdown">
                    <li class="sidebar-item {{ Route::is('kategori-barang.*') ? 'active' : '' }}">
                        <a href="{{ route('kategori-barang.index') }}"
                            class="sidebar-link {{ $isBarangActive ? 'text-light' : '' }}">Kategori Barang</a>
                    </li>
                    <li class="sidebar-item {{ Route::is('barang.*') ? 'active' : '' }}">
                        <a href="{{ route('barang.index') }}"
                            class="sidebar-link {{ $isBarangActive ? 'text-light' : '' }}">Daftar Barang</a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>
</div>
