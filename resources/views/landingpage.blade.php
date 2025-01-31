<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
        .cart-icon {
            color: white; /* Warna teks putih */
        }
        .navbar {
            background-color: black !important; /* Warna hitam penuh */
            width: 100%; /* Mencakup seluruh lebar */
        }
        .navbar-nav {
            flex-direction: row;
            gap: 15px;
        }

        .navbar-nav .nav-item {
            margin: 0;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .search-desktop,
        .search-mobile {
            display: none;
        }

        .navbar-toggler {
            border: none;
            outline: none;
        }
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

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 3px;
            background-color: #fff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            top: -8px;
        }

        .navbar-toggler-icon::after {
            top: 8px;
        }

        /* Animasi ketika hamburger dibuka */
        .navbar-toggler.active .navbar-toggler-icon {
            background-color: transparent;
        }

        .navbar-toggler.active .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 0;
        }

        .navbar-toggler.active .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            top: 0;
        }

        .dropdown-menu {
            display: none;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            animation: fadeIn 0.3s ease-in-out;
            border: 1px solid #008C74; /* Garis di pinggir dropdown */
            border-radius: 5px; /* Opsional: Membuat sudut sedikit melengkung */
            background-color: white; /* Latar belakang dropdown */
        }

        /* Menampilkan dropdown saat hover pada dropdown */
        .hover-dropdown:hover .dropdown-menu {
            display: block;
            opacity: 1;
            visibility: visible;
        }

        /* Segitiga pada dropdown */
        .dropdown-menu .dropdown-arrow {
            position: absolute;
            top: -5px;
            left: 50%;
            margin-left: -5px;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid white;
        }

        /* Gaya item dropdown */
        .dropdown-item {
            padding: 15px 25px;
            font-size: 16px;
            background-color: transparent !important;
            color: #333; /* Warna teks default */
        }

        /* Efek hover pada item dropdown */
        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #f1f1f1 !important; /* Latar belakang saat hover */
            color: #008C74; /* Warna teks tetap terlihat saat hover */
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
@media (min-width: 765px) {
    .search-desktop {
        display: block; /* Menampilkan kolom pencarian di layar besar */
    }
}

/* Media Query untuk layar 320px - 764px (Mobile) */
@media (max-width: 768px) {
    .navbar-toggler {
        display: inline-block; /* Tampilkan hamburger */
    }

    .collapse:not(.show) {
        display: none; /* Menyembunyikan menu navigasi jika belum di-expand */
    }

    .navbar-nav {
        flex-direction: column; /* Navigasi vertikal */
        text-align: left; /* Posisi navigasi di kiri */
    }
    .search-desktop,
        .search-mobile {
            display: none;
        }

    .navbar-nav .nav-item {
        margin-bottom: 2px;
        margin-top: 20px; /* Memberikan jarak antar item */
    }

    .search-container form {
        justify-content: left; /* Kolom pencarian di pojok kiri */
    }

    .search-container input {
        width: 100%; /* Kolom pencarian memenuhi lebar layar */
    }

    .auth-buttons {
        text-align: left; /* Posisi daftar/login di kiri */
        margin-top: 10px;
    }

    .search-mobile {
        display: block; /* Menampilkan kolom pencarian untuk mobile */
    }

    .keranjang {
        position: relative; /* Pastikan elemen relatif terhadap kontainer terdekat */
        margin-right: 20px; /* Menyesuaikan margin kanan agar tidak terlalu jauh */
        top: -5px; /* Pindahkan sedikit ke atas agar sejajar */
    }

    #userDropdown {
        flex-direction: column; /* Tampilkan secara vertikal */
        text-align: left; /* Menyelaraskan teks ke kiri */
        display: none !important;
    }

    #userDropdown .fs-5 {
        font-size: 14px; /* Ukuran font kecil di layar kecil */
        margin-right: 30px;
    }

    #userDropdown .account {
        font-size: 16px; /* Ukuran font untuk nama pengguna */
        text-align: left; /* Menyelaraskan teks nama pengguna ke kiri */
        margin-left: 0; /* Menghapus margin kiri agar teks berada di pojok kiri */
    }
}

/* Media Query untuk layar dengan lebar maksimal 320px */
@media (max-width: 320px) {
    .keranjang {
        margin-right: 40px; /* Memberikan lebih banyak ruang di kanan untuk tampilan lebih rapi */
    }

    /* Penyesuaian ukuran font atau elemen lain untuk layar 320px */
    #userDropdown {
        flex-direction: column;
        text-align: left;
        display: none !important;
    }
    

    #userDropdown .fs-5 {
        font-size: 4px; /* Ukuran font kecil di layar kecil */
        margin-right: 30px;
    }

    #userDropdown .account {
        font-size: 16px; /* Ukuran font untuk nama pengguna */
    }
}

/* Media Query untuk layar 768px - 1024px (Tablet) */
@media (min-width: 768px) and (max-width: 1024px) {
    #userDropdown {
        flex-direction: row; /* Menjaga elemen dalam dropdown tetap horizontal */
        justify-content: space-between; /* Memberikan ruang antara elemen */
    }

    #userDropdown .fs-5 {
        font-size: 16px; /* Ukuran font sedikit lebih besar di layar menengah */
        margin-right: 30px;
    }

    #userDropdown .account {
        font-size: 18px; /* Ukuran font untuk nama pengguna */
    }
    .search-desktop,
        .search-mobile {
            display: none;
        }
}
@media (min-width: 1440px) {
    #dropdownakun{
        display: none !important;
    }
}
@media (max-width: 1024px) {
    #dropdownakun{
        display: none !important;
    }
}

        .hero {
            background: url('https://source.unsplash.com/1600x900/?business') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .features {
            padding: 60px 20px;
        }

        .features .icon {
            font-size: 50px;
            color: #0d6efd;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container">
        <a class="navbar-brand" style="font-size:30px;">Mbak G</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-3">
                <li class="nav-item me-5 mx-5"><a class="nav-link fs-5" href="#features">About us</a></li>
                <li class="nav-item me-5 mx-5"><a class="nav-link fs-5" href="#about">Produk</a></li>
                <li class="nav-item me-5 mx-5"><a class="nav-link fs-5" href="#contact">Testimoni</a></li>
            </ul>
</div>
        </div>
    </div>
</nav>
<!-- Row untuk Search Bar -->
<div class="row justify-content-center" style="background-color: black; padding: 20px 0;">
    <div class="col-1"></div>
    <div class="col-3">
    <!-- Keranjang -->
    <a href="{{ route('order.index') }}" class="keranjang text-decoration-none text-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart cart-icon" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </a>
    </div>
    <!-- Search Bar -->
    <div class="col-2"></div>
    <div class="col-3">
        <div class="search-desktop search-container">
            <form class="d-flex justify-content-end" role="search">
                <input class="form-control me-2" type="search" placeholder="Search in Navbar" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="col-2 d-flex align-items-center justify-content-center ps-3">
        <!-- Akun -->
        @auth
        <div class="dropdownakun hover-dropdown ms-3">
            <a class="user text-decoration-none text-light" id="dropdownakun" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M13.5 8a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6m0 1a6.978 6.978 0 0 0-4.546 1.633A5.985 5.985 0 0 0 8 14a5.985 5.985 0 0 0 4.546-2.367A6.978 6.978 0 0 0 8 10"/>
                </svg>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="{{ route('account.profile') }}">Pengaturan Akun</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
        @guest
        <a href="{{ route('auth.login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
        <a href="{{ route('auth.register') }}" class="btn btn-light btn-sm">Daftar</a>
    @endguest
    @auth
        <div class="dropdown ms-3 hover-dropdown">
            <a class="d-flex align-items-center text-decoration-none text-light" id="userDropdown">
                <p class="fs-5 mb-0 me-2">Welcome</p>
                <span class="account">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('account.profile') }}">Pengaturan Akun</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth
    </div>
    <div class="col-1"></div>
</div>
    <!-- Hero Section -->
    <div class="hero bg-gray">
        <div class="container">
            <h1 class="display-4" style="color:black;">Selamat Datang di Mbak G</h1>
            <p class="lead">Temukan solusi UMKM terbaik untuk bisnis Anda.</p>
            <a href="#features" class="btn btn-primary btn-lg">Jelajahi Fitur</a>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="features">
    <div class="search-mobile search-container">
    <form class="d-flex justify-content-center" role="search">
        <input class="form-control me-2" type="search" placeholder="Search in Categories" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    </div>
        <div class="container">
            <h2 class="text-center mb-4">Fitur Kami</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="icon mb-3">📈</div>
                    <h5>Analisis Bisnis</h5>
                    <p>Pelajari perkembangan bisnis Anda secara mendalam.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon mb-3">🛒</div>
                    <h5>E-commerce</h5>
                    <p>Bangun toko online Anda dengan mudah.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon mb-3">📊</div>
                    <h5>Laporan Keuangan</h5>
                    <p>Kelola keuangan UMKM Anda dengan transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Tentang Kami</h2>
            <p class="text-center">Mbak G adalah platform yang dirancang untuk membantu UMKM di Indonesia berkembang melalui teknologi. Dengan fitur canggih dan layanan terpercaya, kami ingin menjadi mitra terbaik untuk perjalanan bisnis Anda.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Kontak Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Tulis pesan Anda"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Mbak G. Semua Hak Dilindungi.</p>
    </footer>

    <script>
const toggler = document.querySelector('.navbar-toggler');

toggler.addEventListener('click', function () {
    // Toggle the 'active' class to switch the hamburger icon
    this.classList.toggle('active');
    
    // Optional: Ensure that after closing the navbar the icon resets to the initial state
    const isActive = this.classList.contains('active');
    if (!isActive) {
        // Reset icon rotation when the navbar is closed
        setTimeout(() => {
            document.querySelector('.navbar-toggler-icon').style.transition = 'all 0.3s ease';
        }, 300);
    }
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
