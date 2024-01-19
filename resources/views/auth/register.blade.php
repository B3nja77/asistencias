<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Registro</title>
    <link rel="icon" href="https://i.ibb.co/GCGRY85/key.png" type="image/png">
</head>
<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-bold fs-5">Registro</h5>

                        <hr class="my-4">
                        <!-- Registration Form -->
                        <style>
                            body {
                                background-image: url("https://i.ibb.co/n634SMk/vallejo.png");
                                background-repeat: no-repeat;
                                background-size: cover;
                                background-position: center;
                                min-height: 100vh;
                            }

                            .btn-register {
                                font-size: 0.9rem;
                                letter-spacing: 0.05rem;
                                padding: 0.75rem 1rem;
                            }

                            .card {
                                background: linear-gradient(rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
                                color: #333;
                            }

                            .card-title {
                                color: #333333;
                            }

                            .form-control {
                                background-color: #fff;
                                color: #333;
                            }

                            .btn-register {
                                background-color: #007bff;
                                color: #fff;
                            }
                        </style>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                                    autofocus placeholder="Tu nombre">
                                <label for="name">Ingresa tu nombre</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="name@example.com">
                                <label for="email">Ingresa tu correo</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required autocomplete="new-password"
                                    placeholder="Contraseña">
                                <label for="password">Ingresa tu contraseña</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password-confirm"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmar contraseña">
                                <label for="password-confirm">Confirma tu contraseña</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary btn-register text-uppercase fw-bold mb-2"
                                    type="submit">Registrarse</button>
                            </div>
                            <div class="text-center mt-3">
                                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
