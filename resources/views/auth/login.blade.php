<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SiGENDO - Login</title>
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
            padding: 40px;
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
            /* background-color: #ff0000; */
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

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .login-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .form-section {
            width: 100%;
            max-width: 500px; /* Centering the form section */
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .login-content {
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
                <div class="login-content">
                    <div class="img-section">
                        <img src="{{ URL('storage/nusaputra.png') }}" alt="Login Image">
                    </div>
                    <div class="form-section">
                        <h1 class="card-title">Selamat Datang di SiGENDO (Sistem Genetika Jadwal Dosen)</h1>
                        <h2 class="sub-title">Masuk ke Akun Anda</h2>
                        @if(Session::has('msg'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('msg') }}
                        </div>
                        @endif
                        <form action="{{ route('auth.verify') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                            </div>
                            <div class="button-group">
                                <button type="submit" class="btn btn-custom-login">Masuk</button>
                                <a href="{{ route('auth.register') }}" class="btn btn-custom-login">Buat Akun</a>
                            </div>
                            <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('auth.register') }}">Daftar</a></p>
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
