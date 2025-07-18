<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-reslab-square.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/css/mystyle.css'])

    @livewireStyles
    <script src="{{ asset('js/feather.js') }}"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <title>@yield('title', 'Penjadwalan Lab')</title>
</head>

<body x-data x-cloak class="bg-light">

    @include('layouts.header')

    <div class="wrapper d-flex">
        @include('layouts.sidebar')
        <div class="content flex-grow">
            <div class="hidden-container">
                @include('layouts.search-box')
                @include('layouts.notif')
            </div>
            <x-validation></x-validation>
            <div class="my-5 p-3 mx-2">
                @yield('content' ?? '')
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            feather.replace();
        })
    </script>

    @livewireScripts
</body>

</html>
