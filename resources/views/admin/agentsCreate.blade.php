@extends('components.adminLayout')

@section('title', 'Create Agent')

@section('Content')
<div class="container p-4">
    <h2>Create New Agent</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('agentsRegister') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="prc_id">PRC ID</label>
            <input type="text" name="prc_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="contactno">Contact No.</label>
            <input type="text" name="contactno" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="profile_pic">Profile Picture (optional)</label>
            <input type="file" name="profile_pic" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Register Agent</button>
        <a href="{{ route('adminAgents') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
