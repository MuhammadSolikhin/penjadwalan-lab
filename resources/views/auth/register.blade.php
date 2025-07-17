<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar</title>

    {{-- Custom CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/css/mystyle.css'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo-reslab-square.png') }}">

</head>

<body class="hold-transition login-page">
    <div class="container-fluid bg-fullscreen">
        <!-- Navbar -->
        <nav class="navbar bg-body-transparent">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center bg-white p-2 rounded-2" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-reslab-square.png') }}" alt="Logo" width="50"
                        class="d-inline-block align-text-top">
                    <b class="mysite-title mytext-brown mx-3 fs-4"><i>ResLab</i></b>
                </a>
            </div>
        </nav>

        <div class="myspacer-10"></div>

        <div class="d-flex justify-content-center">
            <div class="mycard-md mybg-dark30 p-4 border boder-primary">
                <form action="{{ $page_meta['url'] }}" method="post">
                    @method($page_meta['method'])
                    @csrf
                    <h3>DAFTAR</h3>
                    <hr width="100px" align="left" color="white">
                    <span class="mb-5">Silahkan masukkan beberapa data diri anda</span>
                    <div class="m-5"></div>

                    <!-- User Name Input -->
                    <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                    <div>
                        <input class="myinput @error('nama_lengkap') is-invalid @enderror" type="text" name="nama_lengkap"
                            id="namaLengkap" placeholder="Masukkan nama anda" value="{{ old('nama_lengkap', $register->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>

                    <!-- User Email Input -->
                    <label for="userEmail" class="form-label mt-3">Email</label>
                    <div>
                        <input class="myinput @error('user_email') is-invalid @enderror" type="email" name="user_email"
                            id="userEmail" placeholder="Masukkan email anda" value="{{ old('user_email', $register->user_email) }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <label for="userPassword" class="form-label mt-3">Kata sandi</label>
                    <div>
                        <input class="myinput @error('password') is-invalid @enderror" type="password" name="password"
                            id="userPassword" placeholder="Kata Sandi" required>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Re-Password Input -->
                    <label for="userPasswordConfirm" class="form-label mt-3">Konfrimasi Kata sandi</label>
                    <div>
                        <input class="myinput @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"
                            id="userPasswordConfirm" placeholder="Masukkan kembali kata sandi anda" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Lupa Password -->
                    {{-- <div class="text-right m-2"><a class="text-light" href="#"><b>Lupa Password</b></a></div> --}}

                    <!-- Spacer -->
                    <div style="height: 50px;"></div>

                    <button class="mybtn mybtn-primary w-100 p-3" type="submit" value="Login">Daftar</button>

                </form>
                <p class="text-center mt-3">Sudah punya akun? <a class="text-light text-decoration-none" href="/login"><b>Login</b></a>
                    disini</p>
            </div>
        </div>

        <div class="myspacer-10"></div>

    </div>
    <!-- /.login-box -->

</body>

</html>
