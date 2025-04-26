{{-- @extends('components.layout')

@section('title', 'Register')

@section('Content')

<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="registration-container">
        <div class="image-section" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?fit=crop&w=1500&q=80');"></div>
        <div class="form-section">
            <div class="form-header">
                <a href="{{route ('show.login')}}">Back</a>
                <h2>Register</h2>
                <span class="company-name">CanaanLand</span>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-row">
                    <div class="form-group">
                        <input type="text" name="fname" placeholder="First Name" required value="{{ old('fname') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" placeholder="Lastname" required value="{{ old('lname') }}">
                    </div>
                </div>
            
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}">
                </div>
            
                <div class="form-group">
                    <input type="tel" name="contactno" placeholder="Contact Number" required value="{{ old('contactno') }}">
                </div>
            
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
                </div>
            
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Retype Password" required>
                </div>
            
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">Terms & Agreement</label>
                </div>
            
                <div class="divider"></div>
            
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>






