<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    {{-- @if (session('must_logout'))
    <script>
        alert("{{ session('must_logout') }}");
    </script>
@endif --}}
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
        <!-- Sidebar -->
        <div class="sidebar p-4">
            <div class="d-flex flex-column align-items-center mb-4">
                <i class="fas fa-desktop fa-7x logo mb-1"></i>
                <h4 class="m-0" style="font-size: 32px">Admin</h4>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="{{route('agentDashboard')}}"><i class="fas fa-user me-2"></i>Dashboard</a>
                <a class="nav-link" href="#"><i class="fas fa-list me-2"></i> Listings</a>
                <a class="nav-link" href="#"><i class="fas fa-heart me-2"></i> Favorites</a>
                <a class="nav-link" href="{{route('maps')}}"><i class="fas fa-map-marked-alt me-2"></i> Map</a>
                <a class="nav-link" href="#"><i class="fas fa-envelope me-2"></i> Messages</a>
                <a class="nav-link" href="#"><i class="fas fa-home me-2"></i> My Property</a>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('Content')
        </div>
    </div>
</body>
</html>
