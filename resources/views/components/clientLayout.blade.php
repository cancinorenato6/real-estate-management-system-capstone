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
            --primary-color: #0E2A2A;
            --accent-color: #D76445;
            --secondary-color: #6c757d;
            --light-bg: #f8f9fa;
            --hover-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: var(--primary-color);
            color: white;
            position: sticky;
            top: 0;
            transition: all 0.3s;
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
        
        /* Content area styles */
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }
        
        /* Card styles */
        .card {
            border-radius: 10px;
            border: none;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        /* Button styles */
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
        
        /* Form styles */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(14, 42, 42, 0.25);
        }
        
        /* Hover effects */
        .hover-shadow {
            transition: all 0.3s ease;
        }
        
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        /* Property card animations */
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
        
        /* Toast and animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .animate-pulse {
            animation: pulse 0.3s ease-in-out;
        }
        
        /* Footer */
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
        
        /* Custom scrollbar */
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
    <!-- Toast container for notifications -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;"></div>
    
    <!-- Session alerts -->
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
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="d-flex flex-column align-items-center">
                    <i class="fas fa-handshake fa-4x logo mb-2"></i>
                    <h3 class="m-0">Canaanland</h3>
                    <small class="text-light opacity-75">Real Estate Solutions</small>
                </div>
            </div>
            
            <nav class="nav flex-column px-3">
                <a class="nav-link {{ request()->routeIs('clientsProfile') ? 'active' : '' }}" href="{{ route('clientsProfile') }}">
                    <i class="fas fa-user me-2"></i> My Profile
                </a>
                <a class="nav-link {{ request()->routeIs('clientsListings') ? 'active' : '' }}" href="{{ route('clientsListings') }}">
                    <i class="fas fa-list me-2"></i> Browse Properties
                </a>
                <a class="nav-link {{ request()->routeIs('messages') ? 'active' : '' }}" href="{{ route('messages') }}">
                    <i class="fas fa-envelope me-2"></i> Messages
                    @php
                        use App\Models\Message;
                        use Illuminate\Support\Facades\Auth;
                        $total_unread = Auth::guard('client')->check() 
                            ? Message::where('client_id', Auth::guard('client')->user()->id)
                                ->where('sender_type', 'agent')
                                ->where('is_read', false)
                                ->count() 
                            : 0;
                    @endphp
                    @if($total_unread > 0)
                        <span class="badge bg-danger rounded-pill float-end">{{ $total_unread }}</span>
                    @endif
                </a>
                <a class="nav-link {{ request()->routeIs('clientsFavorites') ? 'active' : '' }}" href="{{ route('clientsFavorites') }}">
                    <i class="fas fa-heart me-2"></i> My Favorites
                </a>
                <a class="nav-link {{ request()->routeIs('maps') ? 'active' : '' }}" href="{{ route('maps') }}">
                    <i class="fas fa-map-marked-alt me-2"></i> Property Map
                </a>
                {{-- <a class="nav-link {{ request()->routeIs('messages') ? 'active' : '' }}" href="{{ route('messages') }}">
                    <i class="fas fa-envelope me-2"></i> Messages
                    @if(isset($total_unread) && $total_unread > 0)
                        <span class="badge bg-danger rounded-pill float-end">{{ $total_unread }}</span>
                    @endif
                </a> --}}

                {{-- <a class="nav-link {{ request()->routeIs('myProperty') ? 'active' : '' }}" href="{{ route('myProperty') }}">
                    <i class="fas fa-home me-2"></i> My Properties
                </a> --}}
                
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

        <!-- Main Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main Content -->
            <div class="main-content">
                @yield('Content')
            </div>
            
            <!-- Footer -->
            <footer class="text-center py-3">
                <div class="container">
                    <small>&copy; 2025 Canaanland Realty. All rights reserved.</small>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Add active class to current nav link
            const currentLocation = window.location.href;
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                if (link.href === currentLocation) {
                    link.classList.add('active');
                }
            });
        });
        
        // Generic function to show toast notifications
        function showToast(message, type = 'success') {
            // Check if toast container exists, create if not
            let toastContainer = document.getElementById('toast-container');
            
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '1050';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toastId = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'toast align-items-center text-white bg-' + type;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            // Determine icon based on type
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'danger') icon = 'exclamation-circle';
            if (type === 'warning') icon = 'exclamation-triangle';
            
            // Toast content
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            // Add toast to container
            toastContainer.appendChild(toast);
            
            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            
            bsToast.show();
            
            // Remove toast element after it's hidden
            toast.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }
    </script>
</body>
</html>