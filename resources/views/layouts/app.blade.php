<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
    html, body {
        overflow-x: hidden;
        width: 100%;
    }

    /* Navbar Styling */
    .navbar {
        background-color: black !important;
        width: 100%;
    }

    .navbar-nav {
        flex-direction: row;
        gap: 15px;
    }

    .navbar-nav .nav-item {
        margin: 0;
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .navbar-nav .nav-link {
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

    /* Dropdown Styles */
    .dropdown-menu {
        display: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
        animation: fadeIn 0.3s ease-in-out;
        border: 1px solid #008C74;
        border-radius: 5px;
        background-color: white;
    }

    .hover-dropdown:hover .dropdown-menu {
        display: block;
        opacity: 1;
        visibility: visible;
    }

    .dropdown-item {
        padding: 15px 25px;
        font-size: 16px;
        background-color: transparent !important;
        color: #333;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #f1f1f1 !important;
        color: #008C74;
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    /* Hero Section and Features */
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

    /* Media Queries */

    /* For tablet and below */
    @media (max-width: 768px) {
        .navbar-nav {
            flex-direction: column;
            text-align: left;
        }

        .navbar-nav .nav-item {
            margin-bottom: 2px;
            margin-top: 20px;
        }

        .auth-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 100%;
        }

        .user-info {
            position: absolute;
            top: 10px;
            right: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-text {
            font-size: 16px;
            margin-right: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .back-button {
            display: inline-block;
            padding: 8px 15px;
            background-color: #008C74;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #006f56;
        }

        .logout-button {
            display: inline-block;
            padding: 8px 15px;
            background-color: #d9534f;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout-button:hover {
            background-color: #c9302c;
        }
    }
    @media (min-width: 769px) {
            .hover-dropdown {
                position: absolute;
                right: auto; /* Remove right positioning */
                left: 75%; /* Position from left instead */
                top: 50%;
                transform: translateY(-50%);
                z-index: 1000;
            }
        }

        /* Tablet view (768px to 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .hover-dropdown {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background-color: rgba(0, 0, 0, 0.8);
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 1000;
            }
        }

        /* Mobile view (less than 768px) */
        @media (max-width: 767px) {
            .hover-dropdown {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background-color: rgba(0, 0, 0, 0.8);
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 1000;
            }

            .hover-dropdown .dropdown-menu {
                position: absolute;
                bottom: 100%;
                left: 0;
                margin-bottom: 5px;
            }
        }

        /* Ensure welcome text is visible */
        .hover-dropdown a {
            color: white !important;
            font-weight: 500;
        }

        /* Make dropdown more visible on mobile/tablet */
        .hover-dropdown .dropdown-menu {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Smooth transitions */
        .hover-dropdown {
            transition: all 0.3s ease;
        }
</style>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container">
            <!-- Keep your existing navbar content -->
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-3">
                    <li class="nav-item me-2"><a class="nav-link fs-5" >Mbak G</a></li>
                </ul>
                <ul class="navbar-nav ms-auto mb-3">
                    <li class="nav-item me-4"><a class="nav-link fs-5" href="{{'landingpage'}}">Go to Landingpage</a></li>
                </ul>
                <!-- Guest section -->
                <div class="ms-1 mb-3 d-flex align-items-center">
                    @guest
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                        <a href="{{ route('auth.register') }}" class="btn btn-light btn-sm">Daftar</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Welcome message with updated positioning -->
    @auth
    <div class="hover-dropdown">
        <a class="d-flex align-items-center text-decoration-none" id="userDropdown">
            <p class="mb-0 me-2">Welcome</p>
            <span>{{ Auth::user()->name }}</span>
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
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
