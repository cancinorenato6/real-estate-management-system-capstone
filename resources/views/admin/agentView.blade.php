@extends('components.adminLayout')

@section('title', 'View Agent')

@section('Content')
<div class="container py-5">
    <div class="card shadow-lg rounded animate__animated animate__fadeIn">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="{{ $agent->profile_pic ? asset('storage/' . $agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}" 
                     alt="Profile Picture" 
                     width="120" height="120">
                <h2 class="mt-3">{{ $agent->name }}</h2>
                <p class="text-muted">{{ $agent->email }}</p>
                <span class="badge {{ $agent->status == 1 ? 'badge-success' : 'badge-secondary' }}">
                    {{ $agent->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h5><i class="fas fa-id-card" style="color: #D76445;"></i> PRC ID</h5>
                        <p>{{ $agent->prc_id }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h5><i class="fas fa-user" style="color: #D76445;"></i> Username</h5>
                        <p>{{ $agent->username }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h5><i class="fas fa-birthday-cake" style="color: #D76445;"></i> Birthday</h5>
                        <p>{{ \Carbon\Carbon::parse($agent->birthday)->format('F d, Y') }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h5><i class="fas fa-phone" style="color: #D76445;"></i> Contact Number</h5>
                        <p>{{ $agent->contactno }}</p>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="info-box">
                        <h5><i class="fas fa-map-marker-alt" style="color: #D76445;"></i> Address</h5>
                        <p>{{ $agent->address }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h3 style="text-align: center">Listed Properties</h3>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('adminAgents') }}" class="btn btn-outline-primary" style="border-color: #D76445; color: #D76445;" 
                   onmouseover="this.style.backgroundColor='#D76445'; this.style.color='white';" 
                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#D76445';">
                    <i class="fas fa-arrow-left"></i> Back to Agents
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Add Animate.css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
