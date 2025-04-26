@extends('components.adminLayout')

@section('title', 'Dashboard')

@section('Content')
    <div>
        @if(Auth::guard('admin')->check())
            <h1 class="h3 mb-2">Welcome, {{ Auth::guard('admin')->user()->first_name }}!</h1>
            <p class="text-success">Admin is logged in.</p>
        @else
            <p class="text-danger">No admin is logged in.</p>
        @endif

        <h2 class="mt-4">Hi, this is Admin</h2>
    </div>
@endsection
