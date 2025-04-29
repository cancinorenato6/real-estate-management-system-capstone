@extends('components.agentLayout')

@section('title', 'Agent Properties')

@section('Content')

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif


<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Your Posted Properties</h2>
        <a href="{{ route('createProperty') }}" class="btn btn-primary">+ Add Property</a>
    </div>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Agent Info inside the card -->
                    <div class="d-flex align-items-center p-3 bg-light border-bottom">
                        <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                             alt="Agent profile"
                             class="rounded-circle me-2"
                             width="40"
                             height="40"
                             style="object-fit: cover;">
                        <div>
                            <strong class="d-block" style="font-size: 0.9rem;">{{ $property->agent->name }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($property->created_at)->format('m/d/y') }}</small>
                        </div>
                    </div>

                    @if(!empty($property->images) && is_array($property->images))
                        <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                        <p class="card-text">
                            <strong>₱{{ number_format($property->price, 2) }}</strong><br>
                            {{ ucfirst($property->offer_type) }} | {{ ucfirst($property->property_type) }}<br>
                            📍 {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                        </p>
                        <a href="{{ route('viewProperties', $property->id) }}" class="btn btn-outline-primary btn-sm">View Post</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No properties found.</p>
        @endforelse
    </div>
</div>


@endsection
