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
        background-color: #ffffff;
    }

    .cart-icon {
        color: white;
    }

    .navbar {
    background-color: #222023;
    background-image: black;
    color: #fff;
    padding: 10px 0;
}

/* Class untuk Gradient */
.urgent {
    background-color: #222023;
    background-image: black;
    background-color: rgba(34, 32, 35, 0.8); /* Warna dengan transparansi */
    color: #fff;
}

    .navbar-brand {
        font-size: 30px;
        color: white !important;
    }

    .navbar-toggler {
        border: none;
        outline: none;
    }

    .navbar-toggler-icon {
        width: 30px;
        height: 3px;
        background-color: #fff;
        border-radius: 5px;
        position: relative;
        transition: all 0.3s ease;
    }

    .navbar-nav {
        flex-direction: column;
        gap: 10px;
    }

    .navbar-nav .nav-item {
        margin: 0;
    }

    .navbar-nav .nav-link {
        color: white !important;
        font-size: 18px;
    }
    .nav-link{
        color:white !important;
    }

    .search-desktop,
    .search-mobile {
        display: none;
    }

    span.account {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Dropdown */
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
    /* footer */
footer {
  padding: 2rem 0;
  background-color: #222023;
  color:white;
  font-size:1rem;
}
.umkm {
    text-align: justify;
}

.nav-link {
    text-align: left !important;
    padding-left: 0; /* Agar teks lebih sejajar dengan footer-title */
}

.footer-column {
    text-align: left; /* Footer lebih rata dan rapi */
    padding-top: 2rem;
}

.footer-title {
    font-weight: bold;
    font-size: 1.2rem; /* Ukuran judul lebih jelas */
    margin-bottom: 10px; /* Beri jarak dengan elemen di bawahnya */
    display: block; /* Agar judul tampil di satu baris sendiri */
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
    .navbar-toggler {
            display: inline-block;
        }

        .collapse:not(.show) {
            display: none;
        }

        .navbar-nav {
            flex-direction: column;
            text-align: left;
        }

        .navbar-nav .nav-item {
            margin-bottom: 2px;
            margin-top: 20px;
        }

        .search-container form {
            justify-content: left;
        }

        .search-container input {
            width: 100%;
        }

        .auth-buttons {
            text-align: left;
            margin-top: 10px;
        }

        .search-mobile {
            display: block;
        }

        .keranjang {
            position: relative;
            margin-right: 20px;
            top: -5px;
        }

        .d-flex.justify-content-end {
            justify-content: flex-start !important;
        }

        #userDropdown {
            margin-left: 0;
        }

        .account {
            font-size: 1rem;
        }

        #userDropdown .fs-5 {
            font-size: 14px;
            margin-right: 30px;
        }

        #userDropdown .account {
            font-size: 16px;
            text-align: left;
            margin-left: 0;
        }
    .col-sm-4 {
        width: 100%; /* Bisa disesuaikan */
        max-width: 400px; /* Atau sesuaikan sesuai keinginan */
        margin: 0 auto; /* Agar tetap di tengah */
    }
    .btn.btn-success {
        width: 70%; /* Memperbesar tombol agar lebih nyaman di klik */
    }
    .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
/* Media Query untuk layar dengan lebar maksimal 320px */
@media (max-width: 320px) {
    .keranjang {
            margin-right: 40px;
        }

        #userDropdown {
            flex-direction: column;
            text-align: left;
            display: none;
        }

        #userDropdown .fs-5 {
            font-size: 4px;
            margin-right: 30px;
        }

        #userDropdown .account {
            font-size: 16px;
        }
            .red-btn {
        background-color: #dc3545;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;

    }
    .menu{
        margin-top: 20px;

    }
    }
/* Media Query untuk layar 768px - 1024px (Tablet) */
@media (min-width: 768px) and (max-width: 1024px) {
    #userDropdown {
            flex-direction: row;
            justify-content: space-between;
        }

        #userDropdown .fs-5 {
            font-size: 16px;
            margin-right: 30px;
        }

        #userDropdown .account {
            font-size: 18px;
        }

        .search-desktop,
        .search-mobile {
            display: none;
        }

        .hero h1 {
            font-size: 2.5rem;
        }
        .about-footer,
    .page-more-info {
        flex: 0 0 50%; /* Mengatur lebar kolom menjadi 50% */
        max-width: 50%;
    }
    .footer-top {
        text-align: left;
    }
}
@media (min-width: 1440px) {
    #dropdownakun {
            display: none !important;
 }
 .col-sm-4 {
        width: 80%; /* Bisa disesuaikan */
        max-width: 200px; /* Atau sesuaikan sesuai keinginan */
        margin: 0 auto; /* Agar tetap di tengah */
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
}
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #222023;">
    <div class="container">
        <a class="navbar-brand" style="font-size:30px;">Mbak G</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-3">
                <li class="nav-item me-2 mx-4 ps-0 fs-5"><a class="nav-link fs-5" href="#aboutus">About us</a></li>
                <li class="nav-item me-4 mx-3 ps-0 fs-5"><a class="nav-link fs-5" href="#product">Produk</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Row untuk Search Bar -->
<div class="row justify-content-center urgent" style=" padding: 20px 0; background-color: #222023;">
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
            <ul class="dropdown-menu dropdown-menu-end me-4" aria-labelledby="dropdownUser">
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
                <h6 class="fs-5 me-5" style="color:white; font-weight:700:">Welcome, <span class="account">{{ Auth::user()->   name }}</span></h6>
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
<div style="background-color:black"></div>
<div class="py-5 bg-light"></div>
<div class="bg-light py-5"> <!-- Tambahkan py-5 untuk menggantikan mt-5 dan mb-5 -->
<section id="aboutus" class="container-fluid text-center bg-light py-5">
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
 <div class="mt-4" style="background-color:#ffff"></div>
 <section id="product" class="container text-center py-5 bg-light">
    <div class="row mt-5 my-5py-5 px-3 rounded">
        <h2 class="mb-4">Produk Kami</h2>
        <div class="col-md-3"></div>
        
        <!-- Susu Jeli -->
        <div class="col-md-6">
            <div class="card p-5 w-80">
                <i class="card-title my-5 mb-5 fs-4">Susu Jeli dan yogurt</i>
                <p class="card-text justify-center my-4 mb-4 mt-5 fs-3" style="margin-top:10px;">jangan lupa mengirim pesan melalui whatsAPP jika ingin membeli</p>
                <div class="d-flex justify-content-center mt-3" style="margin-top:50px;">
                <a href="{{ route('user.product') }}" class="btn btn-success btn-md my-3" style="width: 40%;">Pesan</a>
                </div>
            </div>
    </div>

        <div class="col-md-3"></div>
    </div>
</section>
    <!-- footer -->
    <footer>
  <div class="container">
    <div class="row">
      <!-- Kolom Produk -->
      <div class="col-md-4 footer-column" style="color:white">
        <ul class="nav flex-column">
          <li class="nav-item">
            <span class="footer-title">UMKM mbak G</span>
          </li>
          <li class="nav-item">
            <a class="nav-link umkm">UMKM yang bergerak di bidang penjualan susu jeli dan yogurt, menggunakan bahan-bahan berkualitas tinggi dan tentunya menyehatkan.</a>
          </li>
        </ul>
      </div>

      <!-- Kolom Perusahaan -->
      <div class="col-md-4 footer-column" style="color:white">
        <ul class="nav flex-column">
          <li class="nav-item">
            <span class="footer-title">Cari kembali</span>
          </li>
          <li class="nav-item"><a class="nav-link" href="#aboutus">About us</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.product') }}">List product</a></li>
        </ul>
      </div>

      <!-- Kolom Kontak & Dukungan -->
      <div class="col-md-4 footer-column">
        <ul class="nav flex-column">
          <li class="nav-item">
            <span class="footer-title">Contact & Support</span>
          </li>
          <li class="nav-item"><a class="nav-link"><i class="fas "></i> radityafebriandaru@gmail.com</a></li>
          <li class="nav-item"><span class="nav-link"><i class="fas"></i> location : Jl jangli krajan barat III 226</span></li>
        </ul>
      </div>
    </div>

    <!-- Pemisah -->
    <div class="text-center"><i class="fas fa-ellipsis-h"></i></div>
    
    <!-- Bagian Bawah Footer -->
    <div class="row text-center mt-5">
      <div class="col-md-12 box">
        <span class="copyright quick-links">Copyright &copy; E-commerce Mbak G <script>document.write(new Date().getFullYear())</script></span>
      </div>
    </div>
  </div>
</footer>
</div>
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
