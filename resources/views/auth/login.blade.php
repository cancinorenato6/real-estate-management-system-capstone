@extends('components.layout')

@section('title', 'Login')

@section('Content')

<link rel="stylesheet" href="{{ asset ('css/login.css')}}">
@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            width: '300px',
        });
    </script>
@endif

<div class="login-container">
    <div class="image-section" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?fit=crop&w=1500&q=80');"></div>
    <div class="form-section">
        <div class="form-header">
            <h2>Login</h2>
        @if(session('error'))
            <p style="color:red;">{{ session('error') }}</p>
        @endif
        </div>
        <form method="POST" action="{{route('show.login')}}">
            @csrf
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required><br>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required><br>
            </div>
            
            <button type="submit" class="login-button">Log In</button>
            
            <a href="#" class="forgot-password">Forgot password?</a>
            @guest
            <a href="{{route ('show.register')}}" class="create-account">Create Account?</a>
            @endguest
        </form>
    </div>
</div>

@endsection