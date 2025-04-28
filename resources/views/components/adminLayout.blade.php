<!DOCTYPE html>
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
                {{-- <i class="fas fa-desktop fa-7x logo mb-1"></i> --}}
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

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('Content')
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
