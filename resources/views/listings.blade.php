{{-- @extends('components.layout')

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

@endsection --}}

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
@endsection