<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* position: sticky; */
            position: static;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            width: 40px;
            height: 40px;
        }

        .logo-container strong {
            font-size: 1.2rem;
            color: #0E2A2A;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
        }

        .nav-links li a {
            text-decoration: none;
            color: #0E2A2A;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links li a:hover {
            color: #E76F51;
        }

        .cta-button {
            background-color: #D76445;
            color: white;
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #E76F51;
        }

        /* .footer {
            background-color: #0E2A2A;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        } */

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-right {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                margin-top: 1rem;
            }

            .nav-links {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .cta-button {
                width: 100%;
                margin-top: 0.5rem;
            }
        }
    </style>
    <!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Optional Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert2 (Optional for alerts) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Your custom CSS (optional) -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    @section('header')
        <header>
            <nav>
                <div class="logo-container">
                    <img src="{{ asset('img/canaanlandFavIcon.png') }}" alt="Logo">
                    <strong>CANAANLAND</strong>
                </div>

                <div class="nav-right">
                    <ul class="nav-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('listings') }}">Listings</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    @guest
                        <a href="{{ route('show.login') }}"><button class="cta-button">Login</button></a> 
                    @endguest
                    
                </div>
            </nav>
        </header>
    @show

    <main>
        @yield('Content')
    </main>

    {{-- @section('footer')
    <footer class="footer">
        <p>&copy; 2025 Canaanland Realty Corporation. All rights reserved.</p>
    </footer>
    @show --}}
    <!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')



</body>
</html>
