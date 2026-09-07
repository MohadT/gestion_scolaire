<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Scolaire</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/fontawesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        /* Centrage parfait */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            background: #f5f7fa;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        /* Carte de connexion */
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 40px;
            animation: fadeInUp 0.6s ease;
        }

        /* Logo */
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            max-width: 80px;
            margin-bottom: 15px;
        }

        .login-logo h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a237e;
            margin: 0;
        }

        .login-logo p {
            color: #888;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Formulaire */
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: #fafbfc;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            background: white;
        }

        .btn-login {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 24px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .btn-login i {
            margin-right: 8px;
        }

        /* Alertes */
        .alert {
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .alert ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .alert ul li::before {
            content: "•";
            margin-right: 8px;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 25px 20px;
            }

            .login-logo h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card">
                <!-- Logo -->
                <div class="login-logo">
                    <img src="{{ asset('assets/images/logo/logo-white.svg') }}" alt="Logo" onerror="this.style.display='none'">
                    <h3>Gestion Scolaire</h3>
                    <p>Connectez-vous à votre compte</p>
                </div>

                <!-- Erreurs de validation -->
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-regular fa-circle-exclamation me-2"></i>
                        <strong>Erreur !</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Message de succès -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-regular fa-circle-check me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Message d'erreur -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-regular fa-circle-exclamation me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Formulaire -->
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="login" class="form-label">
                            <i class="fa-regular fa-envelope me-1"></i>
                            Email ou identifiant <span class="text-danger">*</span>
                        </label>
                        <input class="form-control {{ isset($errors) && $errors->has('login') ? 'is-invalid' : '' }}"
                               name="login"
                               id="login"
                               type="text"
                               placeholder="Email ou identifiant"
                               value="{{ old('email') }}"
                               required
                               autofocus>
                        @if (isset($errors) && $errors->has('login'))
                            <small class="text-danger">{{ $errors->first('login') }}</small>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fa-regular fa-lock me-1"></i>
                            Mot de passe <span class="text-danger">*</span>
                        </label>
                        <input class="form-control {{ isset($errors) && $errors->has('password') ? 'is-invalid' : '' }}"
                               name="password"
                               id="password"
                               type="password"
                               placeholder="Votre mot de passe"
                               required>
                        @if (isset($errors) && $errors->has('password'))
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fa-regular fa-right-to-bracket"></i>
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS here -->
    <script src="{{ asset('assets/js/vendor/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
