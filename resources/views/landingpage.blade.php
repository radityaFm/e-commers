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
    backdrop-filter: blur(10px); /* Efek blur */
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

    .search-desktop,
    .search-mobile {
        display: none;
    }

    span.account {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Dropdown */
    .dropdown-menu {
        background-color: #f1f1f1;
        border: none;
    }

    .dropdown-item {
        padding: 15px 25px;
        font-size: 16px;
        background-color: transparent !important;
        color: #333;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #f1f1f2 !important;
        color: #008C74;
    }

    .hover-dropdown:hover .dropdown-menu {
        display: block;
        opacity: 1;
        visibility: visible;
    }

    /* Animasi */
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
    h1,
        h2,
        h3,
        h4,
        h5,
        h6 {}
        a,
        a:hover,
        a:focus,
        a:active {
            text-decoration: none;
            outline: none;
        }
        
        a,
        a:active,
        a:focus {
            color: #333;
            text-decoration: none;
            transition-timing-function: ease-in-out;
            -ms-transition-timing-function: ease-in-out;
            -moz-transition-timing-function: ease-in-out;
            -webkit-transition-timing-function: ease-in-out;
            -o-transition-timing-function: ease-in-out;
            transition-duration: .2s;
            -ms-transition-duration: .2s;
            -moz-transition-duration: .2s;
            -webkit-transition-duration: .2s;
            -o-transition-duration: .2s;
        }
        
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        img {
    max-width: 100%;
    height: auto;
}
        section {
            padding: 60px 0;
           /* min-height: 100vh;*/
        }
.btn {
    text-transform: uppercase;
    -webkit-transition: all 0.8s;
    -moz-transition: all 0.8s;
    -o-transition: all 0.8s;
    transition: all 0.8s;
}
.red-btn {
    background: #ed1b24;
    border: 2px solid #ed1b24;
    color: #fff;
}

.red-btn:hover{
    background: #1c376c;
    color: #fff;
    border-color: #ffffff;
}

/*---------footer---------*/
footer {
    background-color: #222023;
    background-image: -webkit-linear-gradient( top, #222023, #1e2c47 );
    background-image: -moz-linear-gradient( top, #222023, #1e2c47 );
    background-image: -o-linear-gradient( top, #222023, #1e2c47 );
    background-image: linear-gradient( to bottom, #222023, #1e2c47 );
    color: #fff;
    padding: 220px 0;
    font-size: 17px;
}
footer h3 {
    font-size: 24px;
    font-weight: 600;
    letter-spacing: 1px;
}
footer h4 {
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 1px;
    display: inline-block;
    margin-bottom: 2px;
}
.about-footer li i {
    position: absolute;
    left: 0;
}
.about-footer li {
    padding-left: 40px;
    position: relative;
    margin-bottom: 40px;
}

.about-footer ul {
    margin-top: 40px;
}

footer a {
    color: #fff;
}

footer a:hover {
    color: #ed1b24;
}
.footer-title {
    border-bottom: 2px solid #a61f2d;
    padding-bottom: 25px;
    margin-bottom: 35px;
}

ul.footer-social {
    float: right;
}

ul.footer-social li {
    display: inline;
    margin-right: 16px;
}

ul.footer-social i {
    width: 30px;
    height: 30px;
    background: #fff;
    color: #222025;
    text-align: center;
    line-height: 30px;
    border-radius: 30px;
    font-size: 16px;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
    font-weight: 800;
}

ul.footer-social li:last-child {
    margin-right: 0px;
}

ul.footer-social i:hover {
    background: #ed1b24;
    color: #fff;
}

.page-more-info li {
    margin-bottom: 31px;
}

footer .table td:first-child {
    font-weight: 600;
    padding-left: 33px;
}

footer .table td:last-child {text-align: right;}
footer .table td {
    padding: 0px;
    border: 0;
}

footer .table tr {
}

footer .table td i {
    position: absolute;
    left: 0px;
    font-size: 21px;
    top: 6px;
}

footer .table td {
    position: relative;
    padding: 4px 0;
}
.footer-logo td {
    padding-right: 4px !important;
}

.footer-logo td:last-child {
    padding-right: 0px !important;
}
footer hr {
    border-color: #9294a0;
}

.footer-bottom p {
    text-align: right;
}
.footer-bottom {
    margin-top: 30px;/* Footer */
}
#footer {
    background-color: #343a40; /* Warna latar belakang footer */
    color: #fff; /* Warna teks */
}

#footer .footer-top {
    padding: 40px 0;
}

#footer .about-footer h3,
#footer .footer-title h4 {
    margin-bottom: 20px;
    font-size: 1.25rem;
    font-weight: bold;
}

#footer ul {
    padding-left: 0;
    list-style: none;
}

#footer ul li {
    margin-bottom: 10px;
}

#footer ul li a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

#footer ul li a:hover {
    color: #ffcc00; /* Warna saat hover */
}

#footer .red-btn {
    background-color: #dc3545; /* Warna tombol */
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

#footer .red-btn:hover {
    background-color: #c82333; /* Warna tombol saat hover */
}

#footer hr {
    border-color: rgba(255, 255, 255, 0.1); /* Warna garis pemisah */
}

#footer .footer-bottom {
    padding: 20px 0;
    font-size: 0.9rem;
}

#footer .footer-bottom a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

#footer .footer-bottom a:hover {
    color: #ffcc00; /* Warna saat hover */
}
/* Footer */
#footer {
    background-color: #343a40;
    color: #fff;
}

.footer-top {
    padding: 40px 0;
}

.about-footer h3,
.page-more-info h4 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.about-footer ul,
.page-more-info ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 20px;
}

.about-footer ul li,
.page-more-info ul li {
    margin-bottom: 15px;
    font-size: 1rem;
}

.about-footer ul li i {
    margin-right: 10px;
    color: #fff;
}

.about-footer .tentang-kami-text {
    text-indent: 30px;
    text-align: justify;
    margin: 0;
    padding: 0;
}

.red-btn {
    background-color: #dc3545;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.red-btn:hover {
    background-color: #c82333;
}

.footer-bottom {
    margin-top: 20px;
}

.footer-bottom p {
    margin: 0;
    font-size: 0.9rem;
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
}

    .btn.btn-success {
        width: 70%; /* Memperbesar tombol agar lebih nyaman di klik */
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
                <h6 class="fs-5 me-5" style="color:white; font-weight:700:">welcome  <span class="account">{{ Auth::user()->   name }}</span></h6>
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
                <p class="card-text justify-center my-4 mb-4 mt-5" style="margin-top:10px;">jangan lupa mengirim pesan melalui whatsAPP jika ingin membeli</p>
                <div class="d-flex justify-content-center mt-3" style="margin-top:50px;">
                    <a href="{{ route('user.product') }}" class="btn btn-success btn-md my-3" >Pesan</a>
                </div>
            </div>
    </div>

        <div class="col-md-3"></div>
    </div>
</section>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3" id="footer">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <!-- Kolom Tentang Kami -->
                <div class="col-md-6 col-lg-6 about-footer mb-2">
                    <h3>Tentang Kami</h3>
                    <ul class="list-unstyled">
                        <li class="me-5">
                            <a><i class="fas fa-phone fa-flip-horizontal"></i> UMKM Mbak G</a>
                        </li>
                        <li class="me-5">
                            <p class="tentang-kami-text">
                                Memiliki produk utama yaitu susu jeli dan yogurt yang memiliki rasa yang enak, dibuat dengan bahan berkualitas, dan dijual dengan harga yang terjangkau.
                            </p>
                        </li>
                    </ul>
                    <a href="{{ route('user.product') }}" class="btn red-btn">Belanja Sekarang</a>
                </div>
                <div class="col-md-6 col-lg-6 page-more-info mt-2">
                    <div class="footer-title">
                        <h4 class="menu">Menu dan Bantuan</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li><a href="#aboutus">Beranda</a></li>
                        <li><a href="https://wa.me/6287831002289">Hubungi Kami</a></li>
                    </ul>
                    </div>
                </div>
        </div>

        <!-- Garis Pemisah -->
        <hr class="my-4">

        <!-- Footer Bottom -->
        <div class="footer-bottom">
    <div class="row">
        <div class="col-sm-4 text-sm-start">
            <!-- Kolom kosong -->
        </div>
        <div class="col-sm-4 text-sm-center">
            <!-- Teks Hak Cipta -->
            <p >&copy; 2025 UMKM Mbak G. Semua Hak Dilindungi.</p>
        </div>
        <div class="col-sm-4 text-sm-start">
            <!-- Kolom kosong -->
        </div>
    </div>
</div>
    </div>
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
