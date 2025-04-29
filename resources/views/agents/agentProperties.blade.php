@extends('components.agentLayout')

@section('title', 'Agent Properties')

@section('Content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Your Posted Properties</h2>
        <a href="{{ route('createProperty') }}" class="btn btn-primary">+ Add Property</a>
    </div>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if(!empty($property->images) && is_array($property->images))
                        <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                        <p class="card-text">
                            <strong>₱{{ number_format($property->price, 2) }}</strong><br>
                            {{ ucfirst($property->offer_type) }} | {{ ucfirst($property->property_type) }}<br>
                            📍 {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}<br>
                            👤 <strong>Agent:</strong> {{ $property->agent->name }}
                        </p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Manage</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No properties found.</p>
        @endforelse
    </div>
</div>
@endsection
