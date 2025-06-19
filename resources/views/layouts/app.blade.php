<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS and JS -->
<<<<<<< HEAD
    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/css/mystyle.css'])
    <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
=======
    @vite(['resources/css/app.css', 'resources/js/app.js'])

>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Logo Unpam Buat Favicon --}}
    <link rel="icon" href="{{ asset('images/unpam-logo.png') }}" type="image">

    <title>@yield('title', 'Penjadwalan Lab')</title>

</head>
<<<<<<< HEAD
<body class="bg-light">
=======
<body class="pt-4 bg-body-tertiary">
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

    {{-- Header atau Navbar --}}
    @include('layouts.header')

<<<<<<< HEAD
    <div class="wrapper d-flex">
=======
    <div class="wrapper d-flex bg-body-tertiary vh-100">
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Content --}}
<<<<<<< HEAD
        <div class="content flex-grow">
=======
        <div class="content flex-grow pt-3">
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

            <div class="hidden-container">
                <!-- Search Box Disini Biar Lebarnya Sesuai Dengan Content -->
                @include('layouts.search-box')
                @include('layouts.notif')
<<<<<<< HEAD
                @yield('content')
            </div>
=======
            </div>

            {{-- Error Toast --}}
            <x-validation></x-validation>

            @yield('content')
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
        </div>

    </div>


    <script>
<<<<<<< HEAD
        feather.replace();
    </script>


=======
        document.addEventListener("DOMContentLoaded", () => {
            feather.replace();
        })
    </script>
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
</body>
</html>
