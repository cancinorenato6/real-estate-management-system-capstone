<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --primary-color: #0E2A2A;
            --accent-color: #E76F51;
            --cta-color: #D76445;
            --text-color: #333;
            --bg-color: #f9f9f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        header {
            background-color: #fff;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: box-shadow 0.3s ease;
        }

        header.scrolled {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            width: 40px;
            height: 40px;
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: rotate(360deg);
        }

        .logo-container strong {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s ease;
        }

        .mobile-toggle:hover {
            color: var(--accent-color);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
        }

        .nav-links li a {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease, transform 0.2s ease;
            position: relative;
        }

        .nav-links li a:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--accent-color);
            transition: width 0.3s ease;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }

        .cta-button {
            background-color: var(--cta-color);
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-button:hover {
            background-color: var(--accent-color);
            transform: scale(1.05);
        }

        footer {
            background-color: var(--primary-color);
            color: #fff;
            padding: 2rem 1rem;
            margin-top: 2rem;
        }

        .contact-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .contact-column {
            padding: 1rem;
        }

        .contact-column h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }

        .contact-column p {
            font-size: 1rem;
            color: #ddd;
            margin-bottom: 0.75rem;
        }

        .social-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .social-links a {
            color: #ddd;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-color);
        }

        .copyright {
            font-size: 0.95rem;
            color: #bbb;
            margin-top: 1rem;
            text-align: center;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #fff;
            color: var(--text-color);
            transition: box-shadow 0.3s ease;
            width: 100%;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(231, 111, 81, 0.3);
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .send-message {
            background-color: var(--cta-color);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .send-message:hover {
            background-color: var(--accent-color);
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .contact-container {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .contact-column h2 {
                font-size: 1.4rem;
            }

            .contact-column p,
            .social-links a {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 992px) {
            .mobile-toggle {
                display: block;
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1001;
            }

            .nav-links {
                gap: 1rem;
            }

            .logo-container strong {
                font-size: 1.2rem;
            }

            .cta-button {
                padding: 0.5rem 1rem;
            }

            .nav-right {
                display: none;
                flex-direction: column;
                align-items: center;
                width: 100%;
                background-color: #fff;
                padding: 1rem 0;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }

            .nav-right.active {
                display: flex;
                animation: slideDown 0.3s ease forwards;
            }

            .contact-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .form-row {
                flex-direction: column;
            }

            .contact-form input,
            .contact-form textarea {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 0.75rem 1rem;
            }

            .nav-right {
                flex-direction: column;
                align-items: center;
                width: 100%;
                margin-top: 0.5rem;
            }

            .nav-links {
                flex-direction: column;
                gap: 0;
                width: 100%;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links li a {
                font-size: 1.1rem;
                display: block;
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .cta-button {
                width: 100%;
                margin-top: 0.75rem;
            }

            .contact-column {
                padding: 0.75rem;
            }

            .contact-column h2 {
                font-size: 1.3rem;
            }

            .contact-column p,
            .social-links a {
                font-size: 0.9rem;
            }

            .copyright {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            header {
                padding: 0.5rem 0.75rem;
            }

            .logo-container img {
                width: 36px;
                height: 36px;
            }

            .logo-container strong {
                font-size: 1.1rem;
            }

            .mobile-toggle {
                font-size: 1.3rem;
                right: 0.75rem;
            }

            .nav-links li a {
                font-size: 1rem;
                padding: 0.5rem 0;
            }

            .cta-button {
                padding: 0.5rem;
                font-size: 0.9rem;
            }

            .contact-column h2 {
                font-size: 1.2rem;
            }

            .contact-column p,
            .social-links a {
                font-size: 0.85rem;
            }

            .contact-form input,
            .contact-form textarea {
                padding: 0.6rem;
                font-size: 0.9rem;
            }

            .send-message {
                padding: 0.6rem;
                font-size: 0.9rem;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    @section('header')
        <header>
            <nav>
                <div class="logo-container">
                    <img src="{{ asset('img/canaanlandFavIcon.png') }}" alt="Canaanland Logo">
                    <strong>CANAANLAND</strong>
                </div>

                <button class="mobile-toggle" aria-label="Toggle navigation menu">
                    <span class="toggle-icon">
                        <i class="bi bi-list"></i>
                    </span>
                </button>

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
                    @else
                        <a href="{{ route('logout') }}"><button class="cta-button">Logout</button></a>
                    @endguest
                </div>
            </nav>
        </header>
    @show

    <main>
        @yield('Content')
    </main>

    @section('footer')
        <footer id="contact">
            <div class="contact-container">
                <!-- Follow Us Section -->
                <div class="contact-column">
                    <h2>Follow Us</h2>
                    <p>Stay connected!</p>
                    <div class="social-links">
                        <a href="mailto:carecorp010813@gmail.com">carecorp010813@gmail.com</a>
                        <a href="#">canaanland/Facebook</a>
                        <a href="#">canaanland/Telegram</a>
                        <a href="#">canaanland/Viber</a>
                    </div>
                    <p class="copyright">© 2025 Canaanland Realty Corp. <br>All Rights Reserved.</p>
                </div>

                <!-- Contact Our Team Section -->
                <div class="contact-column">
                    <h2>Contact Our Team</h2>
                    <p>Address: CCC, Bangkusay, San Fernando, La Union</p>
                    <p>0927 273 9616</p>
                    <p>123-654-754</p>
                    <p>123-456-890</p>
                    <p>1234567890</p>
                </div>

                <!-- Contact Form Section -->
                <div class="contact-column">
                    <h2>Contact Form</h2>
                    <form class="contact-form" action="#" method="POST">
                        @csrf
                        <div class="form-row">
                            <input type="text" name="first_name" placeholder="First name" required>
                            <input type="text" name="last_name" placeholder="Last name" required>
                        </div>
                        <input type="email" name="email" placeholder="Email" required>
                        <textarea name="message" placeholder="Message" rows="4" required></textarea>
                        <button type="submit" class="send-message">Send Message</button>
                    </form>
                </div>
            </div>
        </footer>
    @show

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            header.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Toggle navigation menu
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.querySelector('.mobile-toggle');
            const navRight = document.querySelector('.nav-right');
            
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    navRight.classList.toggle('active');
                    
                    // Change icon based on menu state
                    const toggleIcon = this.querySelector('.toggle-icon i');
                    if (navRight.classList.contains('active')) {
                        toggleIcon.classList.remove('bi-list');
                        toggleIcon.classList.add('bi-x-lg');
                    } else {
                        toggleIcon.classList.remove('bi-x-lg');
                        toggleIcon.classList.add('bi-list');
                    }
                });

                // Close menu when clicking on a link
                const navLinks = document.querySelectorAll('.nav-links a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        navRight.classList.remove('active');
                        const toggleIcon = mobileToggle.querySelector('.toggle-icon i');
                        toggleIcon.classList.remove('bi-x-lg');
                        toggleIcon.classList.add('bi-list');
                    });
                });
            }
        });

        // Contact form submission with SweetAlert2
        document.querySelector('.contact-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: 'We will get back to you soon.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    form.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to send message. Please try again later.'
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>