<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('styles')
    <style>
        .gradient-custom {
            background: linear-gradient(to bottom, #6a11cb, #2575fc);
        }

        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Efek hover untuk teks dalam dropdown */
        .dropdown-menu li a:hover {
            color: green !important; /* Pengaturan Akun */
        }

        .dropdown-menu li:last-child button:hover {
            color: red !important; /* Logout */
        }

        /* nav hamburger */
        span.account {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .navbar-toggler-icon {
        width: 30px;
        height: 3px;
        background-color: #fff;
        border-radius: 5px;
        position: relative;
        transition: all 0.3s ease;
    }

    /* Menampilkan dropdown saat hover pada dropdown */
    .hover-dropdown:hover .dropdown-menu {
        display: block;
        opacity: 1;
        visibility: visible;
    }

    /* Gaya item dropdown */
    .dropdown-item {
        padding: 15px 25px;
        font-size: 16px;
        background-color: transparent !important;
        color: #333;
    }

    /* Efek hover pada item dropdown */
    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #f1f1f1 !important;
        color: #008C74;
    }

            /* Mengatur lebar dropdown berdasarkan ukuran layar */
        @media (max-width: 768px) {
            .dropdown-menu {
        width: 25%;
        min-width: auto !important;
        }

        .col-md-4 .card {
            border-radius: 12px !important;
        }
        }

        @media (max-width: 425px) {
            .dropdown-menu {
                width: 40%;
            }
        }

        @media (max-width: 375px) {
            .dropdown-menu {
                width: 50%;
            }
        }

        @media (max-width: 325px) {
            .dropdown-menu {
                width: 60%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container">
            <a class="navbar-brand fs-5" href="#">Mbak G</a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fs-5" href="{{('/')}}">Go to Landingpage</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('auth.register') }}">Daftar</a></li>
                    @else
                        <li class="nav-item dropdown mt-1 ">
                            <b><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Welcome {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('account.profile') }}">Pengaturan Akun</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item border-0 bg-transparent">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
        });
    </script>
    @endif
</body>
</html>