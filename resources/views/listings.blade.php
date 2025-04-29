@extends('components.layout')

@section('title', 'Listings')

@section('Content')
<div class="container mt-4">
    <h1 class="mb-4">Available Properties</h1>

    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Agent Info -->
                    <div class="d-flex align-items-center p-2 bg-light border-bottom">
                        <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                             alt="Agent profile"
                             class="rounded-circle me-2"
                             width="40" height="40"
                             style="object-fit: cover;">
                        <div>
                            <strong class="d-block" style="font-size: 0.9rem;">{{ $property->agent->name }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($property->created_at)->format('m/d/y') }}</small>
                        </div>
                    </div>

                    <!-- Property Image -->
                    @if(!empty($property->images) && is_array($property->images))
                        <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif

                    <!-- Property Details -->
                    <div class="card-body">
                        <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                        <p class="card-text">
                            <strong>₱{{ number_format($property->price, 2) }}</strong><br>
                            {{ ucfirst($property->offer_type) }} | {{ ucfirst($property->property_type) }}<br>
                            📍 {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                        </p>
                        <a href="{{ route('pubViewProperties', $property->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No properties available at the moment.</p>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $properties->links() }}
    </div>
</div>
@endsection
