<div class="sidebar mybg-brown100 shadow py-5 px-4 mt-4" id="sidebar">
    <div class="brand-logo gap-2 d-flex align-items-center py-1 my-2">
        <img src="{{ asset('images/unpam-logo.png') }}" width="35px" alt="" srcset="">
        <span class="mytext-brown"><b>Penjadwalan Lab</b></span>
    </div>


    <div class="m-4"></div>

    <ul class="menu-container list-unstyled">

        @php
            $userRole = auth()->user()->role->nama_peran;
            $dashboardRoute = in_array($userRole, ['admin', 'laboran']) ? $userRole . '.dashboard' : 'dashboard';
        @endphp
        <li class="sidebar-item pb-2 px-3 rounded-3 {{ Route::is($dashboardRoute) ? 'mybg-brown active' : 'mybg-brown200' }}">
            <a href="{{ route($dashboardRoute) }}" class="sidebar-link {{ Route::is($dashboardRoute) ? 'text-light' : '' }}">
                <img src="{{ Route::is($dashboardRoute) ? asset('images/icons/home.png') : asset('images/icons/home-black.png') }}" class="mb-1 me-2" width="20px" alt="">Beranda
            </a>
        </li>

        @php
            $manajemenRoutes = ['admin.pengguna', 'laboran.laboratorium', 'admin.barang'];
            $isManajemenActive = in_array(Route::currentRouteName(), $manajemenRoutes);
        @endphp

        @if (in_array($userRole, ['admin', 'laboran']))
            <li class="sidebar-item pb-2 px-3 rounded-3 mt-2 {{ $isManajemenActive ? 'mybg-brown active' : 'mybg-brown200' }}">
                <a href="#" class="sidebar-link d-flex flex-grow collapsed {{ $isManajemenActive ? 'text-light' : '' }}" data-bs-toggle="collapse"
                    data-bs-target="#manajemenDropdown">
                    <i data-feather="command" class="sidebar-icon-link"></i>Manajemen
                    <i data-feather="chevron-right" class="dropdown-icon {{ $isManajemenActive ? 'active' : '' }}"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isManajemenActive ? 'active' : '' }}"
                    id="manajemenDropdown">
                    @if ($userRole === 'admin')
                        <li class="sidebar-item {{ Route::is('admin.pengguna') ? 'active' : '' }}">
                            <a href="{{ route('admin.pengguna') }}" class="sidebar-link {{ $isManajemenActive ? 'text-light' : '' }}">Pengguna</a>
                        </li>
                    @endif
                    <li class="sidebar-item {{ Route::is('laboran.laboratorium') ? 'active' : '' }}">
                        <a href="{{ route('laboran.laboratorium') }}" class="sidebar-link {{ $isManajemenActive ? 'text-light' : '' }}">Laboratorium</a>
                    </li>
                    <li class="sidebar-item {{ Route::is('admin.barang') ? 'active' : '' }}">
                        <a href="{{ route('admin.barang') }}" class="sidebar-link {{ $isManajemenActive ? 'text-light' : '' }}">Barang</a>
                    </li>
                </ul>
            </li>
        @endif

        @php
            $isBookingActive =
                Route::is('proses-pengajuan*') || Route::is('booking*') || Route::is('laboran.proses-pengajuan*');
        @endphp

        <li class="sidebar-item pb-2 px-3 rounded-3 mt-2 {{ $isBookingActive ? 'mybg-brown active' : 'mybg-brown200' }}">
            <a href="#" class="sidebar-link d-flex flex-grow collapsed {{ $isBookingActive ? 'text-light' : '' }}" data-bs-toggle="collapse"
                data-bs-target="#bookingDropdown">
                <i data-feather="calendar" class="sidebar-icon-link"></i>Booking
                <i data-feather="chevron-right" class="dropdown-icon {{ $isBookingActive ? 'active' : '' }}"></i>
            </a>

            <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isBookingActive ? 'active' : '' }}"
                id="bookingDropdown">

                @if ($userRole !== 'laboran')
                    {{-- <li class="sidebar-item {{ Route::is('pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('pengajuan') }}" class="sidebar-link">Pengajuan</a>
                    </li> --}}

                    <li class="sidebar-item {{ Route::is('booking*') ? 'active' : '' }}">
                        <a href="{{ route('booking.index') }}" class="sidebar-link {{ $isBookingActive ? 'text-light' : '' }}">Booking</a>
                    </li>
                @endif


                @if ($userRole == 'laboran' || $userRole == 'admin')
                    <li class="sidebar-item {{ Route::is('proses-pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('proses-pengajuan.index') }}" class="sidebar-link {{ $isBookingActive ? 'text-light' : '' }}">Proses Pengajuan</a>
                    </li>
                @endif
            </ul>
        </li>

    </ul>
</div>
