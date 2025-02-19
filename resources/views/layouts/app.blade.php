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
        
        .navbar {
            background-color: #222023;
            background-image: black;
            background-color: rgba(34, 32, 35, 0.8); /* Warna dengan transparansi */
            backdrop-filter: blur(10px);
            color: #fff;
            padding:28px 0;
        }

    .card {
        margin: 0 auto; /* Membuat card berada di tengah */
        max-width: 1000px; /* Atur lebar maksimum card */
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
    .hover-dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    visibility: visible;
    }

    /* Mencegah dropdown menghilang saat berpindah ke dropdown-menu */
    .hover-dropdown .dropdown-menu {
        display: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    
    /* Animasi fade-in */
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
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
            <div class="navbar-toggler">
                <span class="navbar-toggler-icon"></span>
                <div class="dropdown-menu" style="display: none;">
                    <a href="#" class="dropdown-item">Item 1</a>
                    <a href="#" class="dropdown-item">Item 2</a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fs-5" href="{{('/')}}">Go to Landingpage</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('auth.register') }}">Daftar</a></li>
                    @else
                    <li class="nav-item dropdown mt-1 hover-dropdown">
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

    <main class="mt-5 my-5" style="margin-top:300px;">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    navbarToggler.addEventListener('click', function() {
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
    });
});
    </script>
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