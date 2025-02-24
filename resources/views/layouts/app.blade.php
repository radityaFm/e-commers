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
     main {
            margin-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }

        .navbar {
        background-color: #222023;
    }

    .navbar-toggler {
        border: none;
        outline: none;
        background: none;
        padding: 5px;
    }

    .navbar-collapse {
        background-color: #222023;
    }

    .dropdown-menu {
    position: absolute;
    right: 0; /* Selalu di pojok kanan */
    right: auto !important; /* Pastikan tidak ada pengaturan left yang mengganggu */
    min-width: 200px;
    margin-top: 0.5rem; /* Jarak antara tombol dropdown dan menu */
    transform: translateX(0); /* Pastikan tidak ada pergeseran */
}

.nav-item.dropdown {
    position: relative; /* Agar dropdown tetap mengikuti parent */
}

    .dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        background-color: transparent !important;
        color: #333;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #f1f1f1 !important;
        display: block;
    }
    .dropdown-menu a.dropdown-item:hover {
    color: green !important;
}

/* Untuk Logout (button) */
.dropdown-menu button.dropdown-item:hover {
    color: red !important;
}


        .keranjang-container {
            margin-top: 50%;
        }

        @keyframes hoverEffect {
    0% {
        transform: translateY(0);
        opacity: 1;
        box-shadow: none;
    }
    100% {
        transform: translateY(-5px); /* sedikit naik */
        opacity: 1;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
    border: 1px solid transparent; /* Border awal transparan */
}

.card:hover {
    transform: translateY(-5px); /* Sedikit naik */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Efek bayangan dengan blur lebih */
    border: 1px solid rgba(0, 0, 0, 0.2); /* Border yang menonjol */
}


            /* Mengatur lebar dropdown berdasarkan ukuran layar */
        @media (max-width: 768px) {
            .dropdown-menu {
                width: 50; /* Dropdown mengambil lebar penuh pada layar kecil */
                min-width: auto;
                position: static; /* Dropdown akan mengikuti alur dokumen */
        }

        .col-md-4 .card {
            border-radius: 12px !important;
        }
        .dropdown-menu .dropdown-item,
    .dropdown-menu form button {
        width: 50% !important; /* Paksa tombol hanya 50% */
        text-align: left; /* Rata kiri */
        display: inline-block; /* Pastikan tidak full width */
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
            .dropdown-menu {
        width: 4%; /* Dropdown mengambil lebar penuh pada layar kecil */
        min-width: auto;
        position: static; /* Dropdown akan mengikuti alur dokumen */
    }

    .navbar-toggler {
        display: block; /* Menampilkan toggler pada layar kecil */
    }

    .navbar-collapse {
        display: none; /* Menyembunyikan navbar collapse secara default */
    }

    .navbar-toggler[aria-expanded="true"] + .navbar-collapse {
        display: block; /* Menampilkan navbar collapse saat toggler diklik */
    }
        }
        @media (max-width: 425px) {
    .dropdown-menu {
        width: 100%;
    }
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container pt-3 pb-3">
        <a class="navbar-brand fs-4">Mbak G</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- ms-auto untuk mendorong ke kanan -->
                <li class="nav-item"><a class="nav-link fs-5" href="{{('/')}}">Go to Landingpage</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.register') }}">Daftar</a></li>
                @else
                    <li class="nav-item dropdown mt-1">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <b>Welcome {{ Auth::user()->name }}</b>
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
const toggler = document.querySelector('.navbar-toggler');

toggler.addEventListener('click', function () {
    // Toggle the 'active' class to switch the hamburger icon
    this.classList.toggle('active');
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
        document.addEventListener("DOMContentLoaded", function() {
  // Pilih semua elemen dropdown di navbar
  const dropdowns = document.querySelectorAll('.nav-item.dropdown');

  dropdowns.forEach(function(dropdown) {
    // Saat kursor masuk, tambahkan kelas 'show' untuk menampilkan dropdown
    dropdown.addEventListener("mouseenter", function() {
      const dropdownMenu = this.querySelector('.dropdown-menu');
      if (dropdownMenu) {
        dropdownMenu.classList.add('show');
        // Update aria-expanded agar sesuai dengan status tampilan
        const toggle = this.querySelector('.dropdown-toggle');
        if (toggle) toggle.setAttribute('aria-expanded', 'true');
      }
    });

    // Saat kursor keluar, hapus kelas 'show' agar dropdown menghilang
    dropdown.addEventListener("mouseleave", function() {
      const dropdownMenu = this.querySelector('.dropdown-menu');
      if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
        const toggle = this.querySelector('.dropdown-toggle');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
      }
    });
  });
});
    </script>
    @endif
</body>
</html>