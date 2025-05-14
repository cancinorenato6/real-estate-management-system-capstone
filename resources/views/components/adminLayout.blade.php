{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #0E2A2A;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover {
            color: #D76445;
        }
        .sidebar .logo {
            color: #D76445;
        }
    </style>
</head>
<body>

@if (session('must_logout'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Access Denied',
        text: "{{ session('must_logout') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif
    <div class="d-flex">
   
        <div class="sidebar p-4">
            <div class="d-flex flex-column align-items-center mb-4">
         
                <h4 class="m-0" style="font-size: 32px">CanaanLand</h4>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="{{route('adminDashboard')}}"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
                <a class="nav-link" href="{{route('adminAgents')}}"><i class="fas fa-users-cog me-2"></i> Agents</a>
                <a class="nav-link" href="#"><i class="fas fa-building me-2"></i> Properties</a>
                <a class="nav-link" href="#"><i class="fas fa-map-marked-alt me-2"></i> Maps</a>
                <a class="nav-link" href="#"><i class="fas fa-users me-2"></i> Clients</a>
                <a class="nav-link" href="#"><i class="fas fa-envelope me-2"></i> Messages</a>
                <a class="nav-link" href="#"><i class="fas fa-home me-2"></i> Pages</a>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </div>

        <div class="flex-grow-1 p-4">
            @yield('Content')
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Canaanland</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color:  #0E2A2A;
            --accent-color: #D76445;
            --secondary-color: #6c757d;
            --light-bg: #f8f9fa;
            --hover-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease-in-out;
            transform: translateX(0);
            z-index: 1000;
        }
        
        .sidebar.offcanvas {
            transform: translateX(-100%);
        }
        
        .sidebar .nav-link {
            color: white;
            transition: all 0.3s;
            border-radius: 8px;
            margin-bottom: 5px;
            padding: 10px 15px;
        }
        
        .sidebar .nav-link:hover {
            color: var(--accent-color);
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: var(--accent-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .sidebar .logo {
            color: var(--accent-color);
            transition: all 0.3s;
        }
        
        .sidebar .logo:hover {
            transform: scale(1.05);
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        
        .content-wrapper {
            margin-left: 280px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }
        
        .content-wrapper.offcanvas {
            margin-left: 0;
        }
        
        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }
        
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
            background-color: var(--primary-color);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar-toggle {
                display: block;
            }
            .content-wrapper {
                margin-left: 0;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content-wrapper.show {
                margin-left: 280px;
            }
        }
        
        .card {
            border-radius: 10px;
            border: none;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0a1f1f;
            border-color: #0a1f1f;
        }
        
        .btn-danger {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-danger:hover {
            background-color: #c55a3e;
            border-color: #c55a3e;
        }
        
        .btn-outline-danger {
            color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-outline-danger:hover {
            background-color: var(--accent-color);
            color: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(14, 42, 42, 0.25);
        }
        
        .hover-shadow {
            transition: all 0.3s ease;
        }
        
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .property-image-container {
            overflow: hidden;
            position: relative;
        }
        
        .property-image-container img {
            transition: transform 0.3s ease;
        }
        
        .property-image-container:hover img {
            transform: scale(1.05);
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .animate-pulse {
            animation: pulse 0.3s ease-in-out;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
        
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>
    
    @if (session('must_logout'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Access Denied',
                text: "{{ session('must_logout') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#D76445'
            });
        });
    </script>
    @endif
    
    @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#0E2A2A'
            });
        });
    </script>
    @endif
    
    @if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#D76445'
            });
        });
    </script>
    @endif

    <div class="d-flex">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-handshake fa-4x logo mb-2"></i>
                    <h3 class="m-0">Canaanland</h3>
                    <small class="text-light opacity-75">Real Estate Solutions</small>
                </div>
            </div>
            
            <nav class="nav flex-column px-3">
                <a class="nav-link {{ request()->routeIs('adminDashboard') ? 'active' : '' }}" href="{{ route('adminDashboard') }}">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('adminAgents') ? 'active' : '' }}" href="{{ route('adminAgents') }}">
                    <i class="fas fa-users-cog me-2"></i> Agents
                </a>
                <a class="nav-link {{ request()->routeIs('adminProperties') ? 'active' : '' }}" href="#">
                    <i class="fas fa-building me-2"></i> Properties
                </a>
                <a class="nav-link {{ request()->routeIs('adminMaps') ? 'active' : '' }}" href="#">
                    <i class="fas fa-map-marked-alt me-2"></i> Maps
                </a>
                <a class="nav-link {{ request()->routeIs('adminClients') ? 'active' : '' }}" href="#">
                    <i class="fas fa-users me-2"></i> Clients
                </a>
                <a class="nav-link {{ request()->routeIs('adminPages') ? 'active' : '' }}" href="#">
                    <i class="fas fa-home me-2"></i> Pages
                </a>
                
                <div class="border-top my-3 opacity-25"></div>
                
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
            <div class="mt-auto p-3 text-center sidebar-footer">
                <small class="text-light opacity-75">© 2025 Canaanland Realty</small>
            </div>
        </div>

        <div class="content-wrapper" id="contentWrapper">
            <div class="main-content">
                @yield('Content')
            </div>
            
            <footer class="text-center py-3">
                <div class="container">
                    <small>© 2025 Canaanland Realty. All rights reserved.</small>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                contentWrapper.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768px) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('show');
                        contentWrapper.classList.remove('show');
                    }
                }
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            const currentLocation = window.location.href;
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                if (link.href === currentLocation) {
                    link.classList.add('active');
                }
            });
        });
        
        function showToast(message, type = 'success') {
            let toastContainer = document.getElementById('toast-container');
            
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '1050';
                document.body.appendChild(toastContainer);
            }
            
            const toastId = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'toast align-items-center text-white bg-' + type;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'danger') icon = 'exclamation-circle';
            if (type === 'warning') icon = 'exclamation-triangle';
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }
    </script>
</body>
</html>