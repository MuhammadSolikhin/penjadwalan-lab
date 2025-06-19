<div class="sidebar mybg-brown100 shadow py-3 px-4" id="sidebar">
    <div class="brand-logo gap-2 d-flex align-items-center py-1 my-2">
        <img src="{{ asset('images/unpam-logo.png') }}" width="35px" alt="" srcset="">
        <span class="mytext-brown"><b>Penjadwalan Lab</b></span>
    </div>


    <div class="m-4"></div>

    <ul class="menu-container list-unstyled">
        {{-- Kalau selain admin dan laboran akan diarahkan ke dashboard umum --}}
        <li
            class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 {{ Route::is(in_array(auth()->user()->role->name, ['admin', 'laboran']) ? auth()->user()->role->name . '.dashboard' : 'dashboard') ? 'active' : '' }}">
            <a href="{{ route(in_array(auth()->user()->role->name, ['admin', 'laboran']) ? auth()->user()->role->name . '.dashboard' : 'dashboard') }}"
                class="sidebar-link">
                <img src="{{ asset('images/icons/home-black.png') }}" height="20px" class="sidebar-icon-link">Beranda
            </a>
        </li>

        @php
            // List route buat ke dropdown menu manajemen
            $manajemenRoutes = ['admin.pengguna', 'admin.roles'];
        @endphp

        @if (auth()->user()->role->name !== 'admin' && auth()->user()->role->name !== 'laboran')
            @php
                $userJadwalRoutes = ['allrole.jadwal', 'allrole.pengajuan'];
            @endphp

            <li class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 @if (Str::is($userJadwalRoutes, Route::currentRouteName())) active @endif">
                <a href=""class="sidebar-link d-flex flex-grow collapsed"
                    data-bs-toggle="collapse" data-bs-target="#userJadwalContainer"><img
                        src="{{ asset('images/icons/contract.png') }}" width="20px" class="sidebar-icon-link">Jadwal
                    <i data-feather="chevron-right"
                        class="dropdown-icon
                        @if (Str::is($userJadwalRoutes, Route::currentRouteName())) active @endif
                        "></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla @if (Str::is($userJadwalRoutes, Route::currentRouteName())) active @endif"
                    id="userJadwalContainer">
                    <li
                        class="sidebar-item
                    @if (Str::is('allrole.jadwal', Route::currentRouteName())) active @endif
                    ">
                        <a href="{{ Route('allrole.jadwal') }}" class="sidebar-link">Penggunaan</a>
                    </li>
                    <li
                        class="sidebar-item
                    @if (Str::is('allrole.pengajuan', Route::currentRouteName())) active @endif
                    ">
                        <a href="{{ Route('allrole.pengajuan') }}" class="sidebar-link">Pengajuan</a>
                    </li>
                </ul>
            </li>
        @endif



        {{-- Admin atau Laboran --}}
        @if (auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'laboran')
            @php
                $jadwalRoutes = ['laboran.jadwal', 'laboran.pengajuan'];
            @endphp

            <li class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 @if (Str::is($jadwalRoutes, Route::currentRouteName())) active @endif">
                <a href="" class="sidebar-link d-flex flex-grow collapsed" data-bs-toggle="collapse"
                    data-bs-target="#jadwalContainer"><img src="{{ asset('images/icons/contract.png') }}" width="20px"
                        class="sidebar-icon-link">Jadwal
                    <i data-feather="chevron-right"
                        class="dropdown-icon
                        @if (Str::is($jadwalRoutes, Route::currentRouteName())) active @endif
                        "></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla @if (Str::is($jadwalRoutes, Route::currentRouteName())) active @endif"
                    id="jadwalContainer">
                    <li
                        class="sidebar-item
                    @if (Str::is('laboran.jadwal', Route::currentRouteName())) active @endif
                    ">
                        <a href="{{ Route('laboran.jadwal') }}" class="sidebar-link">Penggunaan</a>
                    </li>
                    <li
                        class="sidebar-item
                    @if (Str::is('laboran.pengajuan*', Route::currentRouteName())) active @endif
                    ">
                        <a href="{{ route('laboran.pengajuan') }}" class="sidebar-link">Pengajuan</a>
                    </li>
                </ul>
            </li>

            @php
                $laboratoriumRoutes = ['laboran.jenis-lab*', 'laboran.laboratorium*'];
            @endphp
            <li class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 @if (Str::is($laboratoriumRoutes, Route::currentRouteName())) active @endif">
                <a href="" class="sidebar-link d-flex flex-grow collapsed" data-bs-toggle="collapse"
                    data-bs-target="#laboratoriumContainer">
                    <img src="{{ asset('images/icons/room.png') }}" width="20px"
                        class="sidebar-icon-link">Laboratorium
                    <i data-feather="chevron-right"
                        class="dropdown-icon @if (Str::is($laboratoriumRoutes, Route::currentRouteName())) active @endif"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla @if (Str::is($laboratoriumRoutes, Route::currentRouteName())) active @endif"
                    id="laboratoriumContainer">
                    <li class="sidebar-item @if (Str::is('laboran.jenis-lab*', Route::currentRouteName())) active @endif">
                        <a href="{{ route('laboran.jenis-lab') }}" class="sidebar-link">Jenis</a>
                    </li>
                    <li class="sidebar-item @if (Str::is('laboran.laboratorium*', Route::currentRouteName())) active @endif">
                        <a href="{{ route('laboran.laboratorium') }}" class="sidebar-link">Laboratorium</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 {{ Route::is('admin.barang*') ? 'active' : '' }}">
                <a href="{{ Route('admin.barang') }}" class="sidebar-link"><img
                        src="{{ asset('images/icons/pc.png') }}" width="20px" class="sidebar-icon-link">Barang</a>
            </li>
        @endif

        @if (auth()->user()->role->name === 'admin')
            <li class="sidebar-item rounded-3 p-3 mb-2 mybg-brown200 @if (in_array(Route::currentRouteName(), $manajemenRoutes)) active @endif">
                <a href="" class="sidebar-link d-flex flex-grow collapsed" data-bs-toggle="collapse"
                    data-bs-target="#manajemenDropdown">
                    <img src="{{ asset('images/icons/settings-black.png') }}" height="20px"
                        class="sidebar-icon-link">Manajemen
                    <i data-feather="chevron-right"
                        class="dropdown-icon @if (in_array(Route::currentRouteName(), $manajemenRoutes)) active @endif"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla @if (in_array(Route::currentRouteName(), $manajemenRoutes)) active @endif"
                    id="manajemenDropdown">
                    <li class="sidebar-item @if (Route::currentRouteName() == 'admin.pengguna') active @endif">
                        <a href="{{ route('admin.pengguna') }}" class="sidebar-link">Pengguna</a>
                    </li>
                    <li class="sidebar-item @if (Route::currentRouteName() == 'admin.roles') active @endif">
                        <a href="{{ route('admin.roles') }}" class="sidebar-link">Roles</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>


{{-- Second Sidebar --}}
<div class="sidebar shadow py-5 px-4" id="sidebar">
    <div class="brand-logo gap-2 d-flex justify-content-center py-1">
        <i data-feather="activity" id="brandIcon"></i>
        <span>Penjadwalan Lab</span>
    </div>
    <hr>

    <ul class="menu-container list-unstyled">

        <span class="divider" style="font-size:0.75rem;">MENU</span>
        @php
            $userRole = auth()->user()->role->nama_peran;
            $dashboardRoute = in_array($userRole, ['admin', 'laboran']) ? $userRole . '.dashboard' : 'dashboard';
        @endphp
        <li class="sidebar-item {{ Route::is($dashboardRoute) ? 'active' : '' }}">
            <a href="{{ route($dashboardRoute) }}" class="sidebar-link">
                <i data-feather="layers" class="sidebar-icon-link"></i>Beranda
            </a>
        </li>

        <span class="divider" style="font-size:0.75rem;">TOOLS</span>

        @php
            $manajemenRoutes = ['admin.pengguna', 'laboran.laboratorium', 'admin.barang'];
            $isManajemenActive = in_array(Route::currentRouteName(), $manajemenRoutes);
        @endphp

        @if(in_array($userRole, ['admin', 'laboran']))
            <li class="sidebar-item {{ $isManajemenActive ? 'active' : '' }}">
                <a href="#" class="sidebar-link d-flex flex-grow collapsed" data-bs-toggle="collapse" data-bs-target="#manajemenDropdown">
                    <i data-feather="command" class="sidebar-icon-link"></i>Manajemen
                    <i data-feather="chevron-right" class="dropdown-icon {{ $isManajemenActive ? 'active' : '' }}"></i>
                </a>

                <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isManajemenActive ? 'active' : '' }}" id="manajemenDropdown">
                    @if($userRole === 'admin')
                        <li class="sidebar-item {{ Route::is('admin.pengguna') ? 'active' : '' }}">
                            <a href="{{ route('admin.pengguna') }}" class="sidebar-link">Pengguna</a>
                        </li>
                    @endif
                    <li class="sidebar-item {{ Route::is('laboran.laboratorium') ? 'active' : '' }}">
                        <a href="{{ route('laboran.laboratorium') }}" class="sidebar-link">Laboratorium</a>
                    </li>
                    <li class="sidebar-item {{ Route::is('admin.barang') ? 'active' : '' }}">
                        <a href="{{ route('admin.barang') }}" class="sidebar-link">Barang</a>
                    </li>
                </ul>
            </li>
        @endif

        @php
            $isBookingActive = Route::is('proses-pengajuan*') || Route::is('booking*')  || Route::is('laboran.proses-pengajuan*'); 
        @endphp

        <li class="sidebar-item {{ $isBookingActive ? 'active' : '' }}">
            <a href="#" class="sidebar-link d-flex flex-grow collapsed" data-bs-toggle="collapse" data-bs-target="#bookingDropdown">
                <i data-feather="calendar" class="sidebar-icon-link"></i>Booking
                <i data-feather="chevron-right" class="dropdown-icon {{ $isBookingActive ? 'active' : '' }}"></i>
            </a>

            <ul class="collapse list-unstyled dropdown-menu-vanilla {{ $isBookingActive ? 'active' : '' }}" id="bookingDropdown">

                @if ($userRole !== "laboran")
                    {{-- <li class="sidebar-item {{ Route::is('pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('pengajuan') }}" class="sidebar-link">Pengajuan</a>
                    </li> --}}

                    <li class="sidebar-item {{ Route::is('booking*') ? 'active' : '' }}">
                        <a href="{{ route('booking.index') }}" class="sidebar-link">Booking</a>
                    </li>
                @endif


                @if ($userRole == "laboran" || $userRole == "admin")
                    <li class="sidebar-item {{ Route::is('proses-pengajuan*') ? 'active' : '' }}">
                        <a href="{{ route('proses-pengajuan.index') }}" class="sidebar-link">Proses Pengajuan</a>
                    </li>
                @endif
            </ul>
        </li>

    </ul>
</div>
