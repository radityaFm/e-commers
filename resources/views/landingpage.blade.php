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
        background-color: #ffff;
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

    /* .navbar-toggler {
        border: none;
        outline: none;
    } */
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

    /* Animasi fade-in */
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Styling untuk navbar row - lebih terang saat hover */
    .navbar-nav .nav-item:hover {
        background-color: rgba(0, 0, 0, 0.6); /* Lebih terang saat hover */
    }

    /* Styling foto dan tulisan agar ke tengah bawah dan lebih besar */
    .hero {
        background: url('https://source.unsplash.com/1600x900/?business') no-repeat center center/cover;
        height: 100vh;
        color: white;
        display: flex;
        align-items: flex-end; /* Menempatkan teks di bawah */
        justify-content: center;
        text-align: center;
        padding-bottom: 50px; /* Memberikan sedikit jarak pada bagian bawah */
    }

    .hero h1 {
        font-size: 3rem; /* Membuat teks lebih besar */
        font-weight: bold;
        margin: 0;
    }

    .hero p {
        font-size: 1.2rem;
        margin-top: 20px;
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
        display: none;
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
        display: none;
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
        .hero h1 {
            font-size: 2.5rem;
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
                <li class="nav-item me-5 mx-5 ps-0"><a class="nav-link fs-5" href="#features">About us</a></li>
                <li class="nav-item me-5 mx-5 ps-0"><a class="nav-link fs-5" href="#about">Produk</a></li>
                <li class="nav-item me-5 mx-5 ps-0"><a class="nav-link fs-5" href="#contact">Testimoni</a></li>
            </ul>
</div>
        </div>
    </div>
</nav>
<!-- Row untuk Search Bar -->
<div class="row justify-content-center" style="background-color: black; padding: 20px 0;">
    <div class="col-1"></div>
    <div class="col-1">
    <!-- Keranjang -->
    <a href="{{ route('cart') }}" class="keranjang text-decoration-none text-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-cart cart-icon" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </a>
    </div>
    <!-- Search Bar -->
    <div class="col-2"></div>
    <div class="col-4">
    </div>
    <div class="col-3 d-flex align-items-center justify-content-center ps-3">
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
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
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
</div>
<div class=" py-2" style="background-color:black"></div>
<div class="py-5 bg-light"></div>
<div class="bg-light py-5"> <!-- Tambahkan py-5 untuk menggantikan mt-5 dan mb-5 -->
    <section id="about" class="container-fluid text-center bg-light">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-1"></div>
            <div class="col-2">
                <img src="{{ asset('img/logo.png') }}" alt="About Us" class="img-fluid">
            </div>
            <div class="col-2"></div>
            <div class="col-5">
                <p class="fs-4" style="color:black;">
                    Umkm mbak G menjual jajanan sehat dan pastinya tanpa mengandung pengawet
                </p>
            </div>
            <div class="col-1"></div>
        </div>
    </section>
</div>
<div class="py-5 bg-light"></div>
<!-- Produk -->
 <div class="mt-4" style="background-color:#D9D9D9"></div>
<section id="products" class="container text-center py-5 mb-5">
    <div class="row mt-5 my-5 bg-white py-5 px-3 rounded">
        <h2 class="mb-4">Produk Kami</h2>
        <div class="col-md-4"></div>
        
        <!-- Susu Jeli -->
        <div class="col-sm-4">
            <div class="card p-4">
                <i class="card-title my-5 mb-4 fs-4">Susu Jeli dan yogurt</i>
                <p class="card-text justify-center my-4 mb-4">jangan lupa mengirim pesan melalui whatsAPP jika ingin membeli</p>
                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ route('user.product') }}" class="btn btn-success btn-md my-3" style="width: 50%;">Pesan</a>
                </div>
            </div>
    </div>

        <div class="col-md-4"></div>
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
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
