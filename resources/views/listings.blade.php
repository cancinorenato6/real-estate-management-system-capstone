@extends('components.layout')

@section('title', 'Listings')

@section('Content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/listings.css') }}">


<div class="container mt-5">
    <!-- Search Filter -->
    <form method="GET" action="{{ route('listings') }}" class="mb-5 p-4 bg-white border rounded shadow-sm">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" placeholder="e.g. City or Province" value="{{ request('location') }}">
            </div>

            <div class="col-md-3">
                <label for="property_type" class="form-label">Property Type</label>
                <select name="property_type" id="property_type" class="form-select">
                    <option value="">Any</option>
                    <option value="condominium" {{ request('property_type') == 'condominium' ? 'selected' : '' }}>Condominium</option>
                    <option value="commercial_space" {{ request('property_type') == 'commercial_space' ? 'selected' : '' }}>Commercial Space</option>
                    <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                    <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="price" class="form-label">Max Price (₱)</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="e.g. 20000" value="{{ request('price') }}">
                <small class="text-muted">Exact matches appear first</small>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('listings') }}" class="btn btn-outline-secondary mt-2">Clear</a>
            </div>
        </div>
    </form>

    <!-- Property Cards -->
    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
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
                    
                    <div class="position-absolute top-0 end-0 m-2">
                        @guest
                            <a href="{{ route('login') }}?login_required=true" class="btn btn-light p-1" style="border-radius: 50%;">
                                <i class="bi bi-heart" style="font-size: 1.3rem; color: red;"></i>
                            </a>
                        @else
                            <button class="btn btn-light p-1" style="border-radius: 50%;">
                                <i class="bi bi-heart" style="font-size: 1.3rem; color: red;"></i>
                            </button>
                        @endguest
                    </div>
                    
                    <!-- Property Details -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                            <p class="card-text mb-2">
                                <strong>₱{{ number_format($property->price, 2) }}</strong><br>
                                {{ ucfirst($property->offer_type) }} | {{ ucfirst($property->property_type) }}<br>
                                📍 {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                            </p>
                        </div>
                        <a href="{{ route('pubViewProperties', $property->id) }}" class="btn btn-outline-primary btn-sm mt-auto">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No properties available at the moment.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $properties->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteButtons = document.querySelectorAll('.favorite-btn');

        favoriteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
            });
        });
    });
</script>

@endsection
