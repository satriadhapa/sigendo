<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SiGENDO - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtu4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url({{ URL('storage/background.png') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .card {
            max-width: 800px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .img-section img {
            width: 110%;
            max-width: 400px;
            height: auto;
            border-radius: 15px;
        }

        .card-title {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Times New Roman', sans-serif;
        }

        .sub-title {
            background-color: #A80063;
            color: white;
            padding: 10px;
            border-radius: 30px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .sub-title-2 {
            /* background-color: #ffffff; */
            color: rgb(0, 0, 0);
            padding: 10px;
            border-radius: 30px;
            text-align: left;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #f1f1f1;
            border: none;
            border-radius: 0;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        .form-control {
            border-radius: 30px;
            border: 1px solid #ddd;
            padding: 10px 20px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #A80063;
            box-shadow: 0 0 8px rgba(168, 0, 99, 0.3);
        }

        .btn-custom-login {
            background-color: #A80063;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-custom-login:hover {
            background-color: #000;
            color: #fff;
        }

        .register-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .form-section {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .register-content {
                flex-direction: row;
                gap: 20px;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="col-lg-8">
            <div class="card">
                <h2 class="sub-title-2">SiGENDO</h2>
                <div class="register-content">
                    <div class="img-section">
                        <img src="{{ URL('storage/nusaputra.png') }}" alt="Register Image">
                    </div>
                    <div class="form-section">
                        <h1 class="card-title">Selamat Datang di SiGENDO (Sistem Genetika Jadwal Dosen)</h1>
                        <h2 class="sub-title">Buat Akun Baru</h2>

                        <!-- Flash Message -->
                        @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif

                        <form action="{{ route('auth.register.store') }}" method="POST">
                            @csrf
                            <!-- Nama Lengkap -->
                            <div class="input-group">
                                <span class="input-group-text" aria-label="Nama Lengkap"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <!-- Email -->
                            <div class="input-group">
                                <span class="input-group-text" aria-label="Email"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <!-- Password -->
                            <div class="input-group">
                                <span class="input-group-text" aria-label="Kata Sandi"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <!-- Konfirmasi Password -->
                            <div class="input-group">
                                <span class="input-group-text" aria-label="Konfirmasi Kata Sandi"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Kata Sandi" required>
                            </div>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="button-group mt-3">
                                <button type="submit" class="btn btn-custom-login">Daftar</button>
                            </div>
                            <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('auth.index') }}">Masuk</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
