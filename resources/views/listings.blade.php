{{-- 

@extends('components.layout')

@section('title', 'Listings')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/listings.css') }}">

<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Browse Properties</h2>
        @auth
            <a href="{{ route('favorites') }}" class="btn btn-outline-danger">
                <i class="bi bi-heart me-1"></i> My Favorites
            </a>
        @endauth
    </div>

    <!-- Search Filter -->
    <form method="GET" action="{{ route('listings') }}" class="mb-5 p-4 bg-white border rounded shadow-sm hover-shadow">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="location" class="form-label">Location</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="location" id="location" class="form-control" placeholder="e.g. City or Province" value="{{ request('location') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="property_type" class="form-label">Property Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                    <select name="property_type" id="property_type" class="form-select">
                        <option value="">Any</option>
                        <option value="condominium" {{ request('property_type') == 'condominium' ? 'selected' : '' }}>Condominium</option>
                        <option value="commercial_space" {{ request('property_type') == 'commercial_space' ? 'selected' : '' }}>Commercial Space</option>
                        <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                        <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label for="price" class="form-label">Max Price (₱)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-cash"></i></span>
                    <input type="number" name="price" id="price" class="form-control" placeholder="e.g. 20000" value="{{ request('price') }}">
                </div>
                <small class="text-muted">Exact matches appear first</small>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Search
                </button>
                <a href="{{ route('listings') }}" class="btn btn-outline-secondary mt-2">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Property Cards -->
    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 col-sm-6 col-12 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <!-- Agent Info -->
                    <div class="d-flex align-items-center p-2 bg-light border-bottom">
                        <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                             alt="Agent profile"
                             class="rounded-circle me-2"
                             width="40" height="40"
                             style="object-fit: cover;">
                        <div>
                            <strong class="d-block" style="font-size: 0.9rem;">{{ $property->agent->name }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}</small>
                        </div>
                    </div>

                    <!-- Property Image -->
                    <div class="property-image-container" style="height: 200px; overflow: hidden; position: relative;">
                        @if(!empty($property->images) && is_array($property->images))
                            <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%; transition: transform 0.3s ease;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                <i class="bi bi-house" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        @endif
                        
                        <!-- Property Type Badge -->
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-primary">{{ ucfirst($property->offer_type) }}</span>
                            <span class="badge bg-info ms-1">{{ ucfirst($property->property_type) }}</span>
                        </div>
                    </div>
                    
                    <!-- Favorite Button -->
                    <div class="position-absolute top-0 end-0 m-2">
                        @guest
                            <a href="{{ route('login') }}?login_required=true" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                                <i class="bi bi-heart" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        @else
                            <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                                @csrf
                                <button type="submit" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                                    <i class="bi {{ $property->favoredBy->contains(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 1.5rem; color: red;"></i>
                                </button>
                            </form>
                        @endguest
                    </div>
                    
                    <!-- Property Details -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                            <p class="card-text mb-1">
                                <strong class="text-primary fs-5">₱{{ number_format($property->price, 2) }}</strong>
                            </p>
                            <p class="card-text mb-2">
                                <i class="bi bi-geo-alt-fill"></i> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                            </p>
                        </div>
                        <a href="{{ route('pubViewProperties', $property->id) }}" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-info-circle me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center p-5">
                    <i class="bi bi-house-x" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">No properties available</h4>
                    <p class="text-muted">
                        @if(request('location') || request('property_type') || request('price'))
                            No properties match your search criteria. Try adjusting your filters.
                        @else
                            No properties are available at the moment. Please check back later.
                        @endif
                    </p>
                    @if(request('location') || request('property_type') || request('price'))
                        <a href="{{ route('listings') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-x-circle me-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $properties->links() }}
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .property-image-container:hover img {
        transform: scale(1.05);
    }
    .favorite-btn:hover {
        background-color: rgba(255, 0, 0, 0.1);
    }
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        .card-body {
            padding: 1rem;
        }
        .card-title {
            font-size: 1.1rem;
        }
        .btn {
            font-size: 0.9rem;
        }
    }
</style>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.animate-pulse {
    animation: pulse 0.3s ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupFavoriteButtons();
    setupCardHoverEffects();
    setupSearchFormAnimations();
});

function setupFavoriteButtons() {
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            button.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    button.classList.add('animate-pulse');
                    icon.classList.toggle('bi-heart-fill', data.favorited);
                    icon.classList.toggle('bi-heart', !data.favorited);
                    showToastNotification(data.favorited);
                    setTimeout(() => button.classList.remove('animate-pulse'), 300);
                } else if (response.status === 401) {
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                button.disabled = false;
            }
        });
    });
}

function showToastNotification(isFavorited) {
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'favorite-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-' + (isFavorited ? 'danger' : 'secondary');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${isFavorited ? 'heart-fill' : 'heart'} me-2"></i>
                Property ${isFavorited ? 'added to' : 'removed from'} favorites
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 3000 });
    bsToast.show();
    toast.addEventListener('hidden.bs.toast', function() { this.remove(); });
}

function setupCardHoverEffects() {
    document.querySelectorAll('.property-image-container img').forEach(img => {
        img.addEventListener('mouseenter', function() { this.style.transform = 'scale(1.05)'; });
        img.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; });
    });

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow');
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow');
            this.style.transform = 'translateY(0)';
        });
    });
}

function setupSearchFormAnimations() {
    const searchForm = document.querySelector('form[action*="listings"]');
    if (searchForm) {
        searchForm.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('border-primary');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('border-primary');
            });
        });
    }
}
</script>
@endsection --}}
@extends('components.layout')

@section('title', 'Listings')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/listings.css') }}">
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" /> --}}

<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        @auth
            <a href="{{ route('favorites') }}" class="btn btn-outline-danger">
                <i class="bi bi-heart me-1"></i> My Favorites
            </a>
        @endauth
    </div>

    <!-- Search Filter -->
    <form method="GET" action="{{ route('listings') }}" class="mb-5 p-4 bg-white border rounded shadow-sm hover-shadow">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="location" class="form-label">Location</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="location" id="location" class="form-control" placeholder="e.g. City or Province" value="{{ request('location') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="property_type" class="form-label">Property Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                    <select name="property_type" id="property_type" class="form-select">
                        <option value="">Any</option>
                        <option value="condominium" {{ request('property_type') == 'condominium' ? 'selected' : '' }}>Condominium</option>
                        <option value="commercial_space" {{ request('property_type') == 'commercial_space' ? 'selected' : '' }}>Commercial Space</option>
                        <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                        <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label for="price" class="form-label">Max Price (₱)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-cash"></i></span>
                    <input type="number" name="price" id="price" class="form-control" placeholder="e.g. 20000" value="{{ request('price') }}">
                </div>
                <small class="text-muted">Exact matches appear first</small>
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Search
                </button>
                <a href="{{ route('listings') }}" class="btn btn-outline-secondary mt-2">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Map Container -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-geo-alt-fill me-2"></i> Property Map
            </h5>
            <div class="badge bg-primary" id="map-counter">
                {{ count($properties) }} Properties Found
            </div>
        </div>
        <div class="card-body p-0">
            <div id="property-map" style="height: 400px; width: 100%; border-radius: 0 0 0.25rem 0.25rem;"></div>
        </div>
    </div>

    <!-- View Toggle -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4>Available Properties</h4>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" id="grid-view-btn">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
            </button>
            <button type="button" class="btn btn-outline-primary" id="list-view-btn">
                <i class="bi bi-list-ul me-1"></i> List
            </button>
        </div>
    </div>

    <!-- Property Cards -->
    <div class="row" id="grid-view">
        @forelse($properties as $property)
            <div class="col-md-4 col-sm-6 col-12 mb-4 property-card" data-property-id="{{ $property->id }}">
                <div class="card h-100 shadow-sm hover-shadow">
                    <!-- Agent Info -->
                    <div class="d-flex align-items-center p-2 bg-light border-bottom">
                        <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                             alt="Agent profile"
                             class="rounded-circle me-2"
                             width="40" height="40"
                             style="object-fit: cover;">
                        <div>
                            <strong class="d-block" style="font-size: 0.9rem;">{{ $property->agent->name }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}</small>
                        </div>
                    </div>

                    <!-- Property Image -->
                    <div class="property-image-container" style="height: 200px; overflow: hidden; position: relative;">
                        @if(!empty($property->images) && is_array($property->images))
                            <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%; transition: transform 0.3s ease;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                <i class="bi bi-house" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        @endif
                        
                        <!-- Property Type Badge -->
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-primary">{{ ucfirst($property->offer_type) }}</span>
                            <span class="badge bg-info ms-1">{{ ucfirst($property->property_type) }}</span>
                        </div>
                    </div>
                    
                    <!-- Favorite Button -->
                    <div class="position-absolute top-0 end-0 m-2">
                        @guest
                            <a href="{{ route('login') }}?login_required=true" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                                <i class="bi bi-heart" style="font-size: 1.5rem; color: red;"></i>
                            </a>
                        @else
                            <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                                @csrf
                                <button type="submit" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                                    <i class="bi {{ isset($property->favoredBy) && $property->favoredBy->contains(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 1.5rem; color: red;"></i>
                                </button>
                            </form>
                        @endguest
                    </div>
                    
                    <!-- Property Details -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                            <p class="card-text mb-1">
                                <strong class="text-primary fs-5">₱{{ number_format($property->price, 2) }}</strong>
                            </p>
                            <p class="card-text mb-2">
                                <i class="bi bi-geo-alt-fill"></i> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                            </p>
                        </div>
                        <a href="{{ route('pubViewProperties', $property->id) }}" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-info-circle me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center p-5">
                    <i class="bi bi-house-x" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">No properties available</h4>
                    <p class="text-muted">
                        @if(request('location') || request('property_type') || request('price'))
                            No properties match your search criteria. Try adjusting your filters.
                        @else
                            No properties are available at the moment. Please check back later.
                        @endif
                    </p>
                    @if(request('location') || request('property_type') || request('price'))
                        <a href="{{ route('listings') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-x-circle me-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- List View -->
    <div class="row d-none" id="list-view">
        <div class="col-12">
            <div class="list-group">
                @forelse($properties as $property)
                    <div class="list-group-item list-group-item-action mb-2 rounded shadow-sm property-card" data-property-id="{{ $property->id }}">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <div style="height: 180px; position: relative; overflow: hidden;">
                                    @if(!empty($property->images) && is_array($property->images))
                                        <img src="{{ asset('storage/' . $property->images[0]) }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-house" style="font-size: 3rem; color: #ccc;"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 m-2">
                                        <span class="badge bg-primary">{{ ucfirst($property->offer_type) }}</span>
                                        <span class="badge bg-info">{{ ucfirst($property->property_type) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                                        @guest
                                            <a href="{{ route('login') }}?login_required=true" class="btn btn-light p-1 favorite-btn">
                                                <i class="bi bi-heart" style="font-size: 1.2rem; color: red;"></i>
                                            </a>
                                        @else
                                            <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                                                @csrf
                                                <button type="submit" class="btn btn-light p-1 favorite-btn">
                                                    <i class="bi {{ isset($property->favoredBy) && $property->favoredBy->contains(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 1.2rem; color: red;"></i>
                                                </button>
                                            </form>
                                        @endguest
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div>
                                            <strong class="text-primary fs-5">₱{{ number_format($property->price, 2) }}</strong>
                                            <p class="card-text mb-2">
                                                <i class="bi bi-geo-alt-fill"></i> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                                            </p>
                                            <div class="mt-2 d-flex align-items-center">
                                                <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                                                    alt="Agent profile" class="rounded-circle me-2" width="30" height="30" style="object-fit: cover;">
                                                <small class="text-muted">{{ $property->agent->name }} · {{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('pubViewProperties', $property->id) }}" class="btn btn-outline-primary ms-auto align-self-end">
                                            <i class="bi bi-info-circle me-1"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item">
                        <div class="alert alert-info text-center p-4">
                            <i class="bi bi-house-x" style="font-size: 2rem;"></i>
                            <h5 class="mt-3">No properties available</h5>
                            <p class="text-muted">
                                @if(request('location') || request('property_type') || request('price'))
                                    No properties match your search criteria. Try adjusting your filters.
                                @else
                                    No properties are available at the moment. Please check back later.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $properties->links() }}
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .property-image-container:hover img {
        transform: scale(1.05);
    }
    .favorite-btn:hover {
        background-color: rgba(255, 0, 0, 0.1);
    }
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
    .property-card {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .property-card:hover {
        transform: translateY(-5px);
    }
    
    /* Leaflet popup customization */
    .leaflet-popup-content {
        margin: 10px;
        min-width: 200px;
    }
    .active-marker-icon {
    transform: scale(1.3) !important;
    filter: drop-shadow(0 0 5px rgba(0, 123, 255, 0.8)) !important;
    z-index: 1000 !important;
}

/* Make sure markers stand out better */
.leaflet-marker-icon {
    transition: all 0.3s ease;
}

/* Improve map popup styling */
.map-popup {
    text-align: center;
    padding: 5px;
}

.map-popup img {
    max-width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 10px;
    border: 2px solid #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.map-popup h5 {
    margin: 5px 0;
    color: #2c3e50;
    font-weight: bold;
}

.map-popup .price {
    font-weight: bold;
    color: #3498db;
    margin-bottom: 5px;
    font-size: 1.1em;
}

.map-popup .location {
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #555;
}

.map-popup .btn {
    margin-top: 5px;
    font-weight: 500;
}

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        .card-body {
            padding: 1rem;
        }
        .card-title {
            font-size: 1.1rem;
        }
        .btn {
            font-size: 0.9rem;
        }
        #property-map {
            height: 300px;
        }
    }
</style>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.animate-pulse {
    animation: pulse 0.3s ease-in-out;
}

/* Active marker customization */
.active-marker {
    z-index: 1000 !important;
}
.active-marker .leaflet-marker-icon {
    transform: scale(1.3);
    filter: drop-shadow(0 0 5px rgba(0, 123, 255, 0.5));
}
</style>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
{{-- <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupFavoriteButtons();
    setupCardHoverEffects();
    setupSearchFormAnimations();
    setupViewToggle();
    initializePropertyMap();
});

// Initialize the property map
// function initializePropertyMap() {
//     // Get property data from PHP
//     const properties = @json($properties->items());
    
//     if (properties.length === 0) {
//         document.getElementById('property-map').style.height = '150px';
//         const mapElement = document.getElementById('property-map');
//         mapElement.innerHTML = `
//             <div class="d-flex align-items-center justify-content-center h-100 bg-light">
//                 <div class="text-center">
//                     <i class="bi bi-map text-muted" style="font-size: 3rem;"></i>
//                     <p class="mt-2 text-muted">No properties to display on the map</p>
//                 </div>
//             </div>
//         `;
//         return;
//     }
    
//     // Initialize map centered on the first property or default to La Union coordinates
//     const defaultCoords = [16.615891, 120.320937]; // La Union
//     let centerLat, centerLng;
    
//     if (properties.length > 0 && properties[0].latitude && properties[0].longitude) {
//         centerLat = properties[0].latitude;
//         centerLng = properties[0].longitude;
//     } else {
//         [centerLat, centerLng] = defaultCoords;
//     }
    
//     const map = L.map('property-map').setView([centerLat, centerLng], 12);
    
//     // Add OpenStreetMap tiles
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
//         maxZoom: 19,
//     }).addTo(map);
    
//     // Initialize marker cluster group
//     const markers = L.markerClusterGroup({
//         spiderfyOnMaxZoom: true,
//         showCoverageOnHover: true,
//         zoomToBoundsOnClick: true
//     });
    
//     // Store markers by property ID for later reference
//     const markersByPropertyId = {};
    
//     // Add markers for each property
//     properties.forEach(property => {
//         if (property.latitude && property.longitude) {
//             // Create property image HTML
//             let imageHtml;
//             if (property.images && property.images.length > 0) {
//                 imageHtml = `<img src="{{ asset('storage') }}/${property.images[0]}" alt="${property.title}">`;
//             } else {
//                 imageHtml = `<div class="bg-light text-center py-3"><i class="bi bi-house" style="font-size: 2rem; color: #ccc;"></i></div>`;
//             }
            
//             // Create popup content
//             const popupContent = `
//                 <div class="map-popup">
//                     ${imageHtml}
//                     <h5>${property.title}</h5>
//                     <div class="price">₱${parseFloat(property.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</div>
//                     <div class="location">
//                         <i class="bi bi-geo-alt-fill"></i> ${property.barangay}, ${property.city}
//                     </div>
//                     <div class="d-flex gap-1 justify-content-center mb-2">
//                         <span class="badge bg-primary">${property.offer_type.charAt(0).toUpperCase() + property.offer_type.slice(1)}</span>
//                         <span class="badge bg-info">${property.property_type.charAt(0).toUpperCase() + property.property_type.slice(1)}</span>
//                     </div>
//                     <a href="{{ url('/pubViewProperties') }}/${property.id}" class="btn btn-sm btn-primary w-100">View Details</a>
//                 </div>
//             `;
            
//             // Create marker
//             const marker = L.marker([property.latitude, property.longitude])
//                 .bindPopup(popupContent, { maxWidth: 300 });
            
//             // Store property ID in marker for interaction
//             marker.propertyId = property.id;
//             markers.addLayer(marker);
            
//             // Store marker reference by property ID
//             markersByPropertyId[property.id] = marker;
//         }
//     });
    
//     // Add marker cluster group to map
//     map.addLayer(markers);
    
//     // Fit map to bounds if there are markers
//     if (markers.getLayers().length > 1) {
//         map.fitBounds(markers.getBounds().pad(0.2));
//     } else if (markers.getLayers().length === 1) {
//         map.setView(markers.getLayers()[0].getLatLng(), 14);
//     }
    
//     // Add click event to property cards to highlight marker on map
//     document.querySelectorAll('.property-card').forEach(card => {
//         card.addEventListener('click', function(e) {
//             // Don't trigger if clicking on buttons or links
//             if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || 
//                 e.target.closest('a') || e.target.closest('button')) {
//                 return;
//             }
            
//             const propertyId = this.dataset.propertyId;
//             const marker = markersByPropertyId[propertyId];
            
//             if (marker) {
//                 // Scroll to map if not in view
//                 const mapElement = document.getElementById('property-map');
//                 const mapRect = mapElement.getBoundingClientRect();
                
//                 if (mapRect.top < 0 || mapRect.bottom > window.innerHeight) {
//                     mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
//                 }
                
//                 // Highlight marker
//                 map.setView(marker.getLatLng(), 15);
//                 marker.openPopup();
//             }
//         });
//     });
    
//     // Update map counter
//     document.getElementById('map-counter').textContent = `${properties.length} Properties Found`;
// }
// Initialize the property map
function initializePropertyMap() {
    // Get property data from PHP
    const properties = @json($properties->items());
    
    if (properties.length === 0) {
        document.getElementById('property-map').style.height = '150px';
        const mapElement = document.getElementById('property-map');
        mapElement.innerHTML = `
            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                <div class="text-center">
                    <i class="bi bi-map text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">No properties to display on the map</p>
                </div>
            </div>
        `;
        return;
    }
    
    // Initialize map centered on the first property or default to La Union coordinates
    const defaultCoords = [16.615891, 120.320937]; // La Union
    let centerLat, centerLng;
    
    if (properties.length > 0 && properties[0].latitude && properties[0].longitude) {
        centerLat = properties[0].latitude;
        centerLng = properties[0].longitude;
    } else {
        [centerLat, centerLng] = defaultCoords;
    }
    
    const map = L.map('property-map').setView([centerLat, centerLng], 9); // Zoomed out further to show more area
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map);
    
    // Store markers by property ID for later reference
    const markersByPropertyId = {};
    const allMarkers = []; // To store all markers for fitting bounds
    
    // Create custom marker icon to make it more visible
    const customIcon = L.icon({
        iconUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/images/marker-shadow.png',
        shadowSize: [41, 41]
    });
    
    // Add individual markers for each property (no clustering)
    properties.forEach(property => {
        if (property.latitude && property.longitude) {
            // Create property image HTML
            let imageHtml;
            if (property.images && property.images.length > 0) {
                imageHtml = `<img src="{{ asset('storage') }}/${property.images[0]}" alt="${property.title}">`;
            } else {
                imageHtml = `<div class="bg-light text-center py-3"><i class="bi bi-house" style="font-size: 2rem; color: #ccc;"></i></div>`;
            }
            
            // Create popup content
            const popupContent = `
                <div class="map-popup">
                    ${imageHtml}
                    <h5>${property.title}</h5>
                    <div class="price">₱${parseFloat(property.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</div>
                    <div class="location">
                        <i class="bi bi-geo-alt-fill"></i> ${property.barangay}, ${property.city}
                    </div>
                    <div class="d-flex gap-1 justify-content-center mb-2">
                        <span class="badge bg-primary">${property.offer_type.charAt(0).toUpperCase() + property.offer_type.slice(1)}</span>
                        <span class="badge bg-info">${property.property_type.charAt(0).toUpperCase() + property.property_type.slice(1)}</span>
                    </div>
                    <a href="{{ url('/pubViewProperties') }}/${property.id}" class="btn btn-sm btn-primary w-100">View Details</a>
                </div>
            `;
            
            // Create marker with custom icon
            const marker = L.marker([property.latitude, property.longitude], {icon: customIcon})
                .bindPopup(popupContent, { maxWidth: 300 })
                .addTo(map); // Add directly to map, no clustering
            
            // Store property ID in marker for interaction
            marker.propertyId = property.id;
            
            // Store marker reference by property ID
            markersByPropertyId[property.id] = marker;
            allMarkers.push(marker);
        }
    });
    
    // Fit map bounds to show all markers with padding
    if (allMarkers.length > 1) {
        const group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds().pad(0.5)); // Add more padding (0.5) to ensure all markers are visible
    } else if (allMarkers.length === 1) {
        map.setView(allMarkers[0].getLatLng(), 13);
    }
    
    // Add click event to property cards to highlight marker on map
    document.querySelectorAll('.property-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on buttons or links
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || 
                e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            
            const propertyId = this.dataset.propertyId;
            const marker = markersByPropertyId[propertyId];
            
            if (marker) {
                // Scroll to map if not in view
                const mapElement = document.getElementById('property-map');
                const mapRect = mapElement.getBoundingClientRect();
                
                if (mapRect.top < 0 || mapRect.bottom > window.innerHeight) {
                    mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                // Highlight marker
                map.setView(marker.getLatLng(), 15);
                marker.openPopup();
                
                // Add highlighting to active marker
                Object.values(markersByPropertyId).forEach(m => {
                    m._icon.classList.remove('active-marker-icon');
                });
                marker._icon.classList.add('active-marker-icon');
            }
        });
    });
    
    // Update map counter
    document.getElementById('map-counter').textContent = `${properties.length} Properties Found`;
}

function setupViewToggle() {
    const gridViewBtn = document.getElementById('grid-view-btn');
    const listViewBtn = document.getElementById('list-view-btn');
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    
    // Toggle between grid and list views
    gridViewBtn.addEventListener('click', function() {
        gridView.classList.remove('d-none');
        listView.classList.add('d-none');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        
        // Store preference in local storage
        localStorage.setItem('propertyViewPreference', 'grid');
    });
    
    listViewBtn.addEventListener('click', function() {
        gridView.classList.add('d-none');
        listView.classList.remove('d-none');
        gridViewBtn.classList.remove('active');
        listViewBtn.classList.add('active');
        
        // Store preference in local storage
        localStorage.setItem('propertyViewPreference', 'list');
    });
    
    // Check user's saved preference
    const savedViewPreference = localStorage.getItem('propertyViewPreference');
    if (savedViewPreference === 'list') {
        listViewBtn.click();
    }
}

function setupFavoriteButtons() {
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            button.disabled = true;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    button.classList.add('animate-pulse');
                    icon.classList.toggle('bi-heart-fill', data.favorited);
                    icon.classList.toggle('bi-heart', !data.favorited);
                    showToastNotification(data.favorited);
                    setTimeout(() => button.classList.remove('animate-pulse'), 300);
                } else if (response.status === 401) {
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                button.disabled = false;
            }
        });
    });
}

function showToastNotification(isFavorited) {
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'favorite-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-' + (isFavorited ? 'danger' : 'secondary');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${isFavorited ? 'heart-fill' : 'heart'} me-2"></i>
                Property ${isFavorited ? 'added to' : 'removed from'} favorites
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 3000 });
    bsToast.show();
    toast.addEventListener('hidden.bs.toast', function() { this.remove(); });
}

function setupCardHoverEffects() {
    document.querySelectorAll('.property-image-container img').forEach(img => {
        img.addEventListener('mouseenter', function() { this.style.transform = 'scale(1.05)'; });
        img.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; });
    });
}

function setupSearchFormAnimations() {
    const searchForm = document.querySelector('form[action*="listings"]');
    if (searchForm) {
        searchForm.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('border-primary');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('border-primary');
            });
        });
    }
}
</script>
@endsection