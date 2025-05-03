@extends('components.clientLayout')

@section('title', 'Property Listings')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('css/listings.css') }}"> --}}
{{-- <script src="{{ asset('js/clientListings.js') }}"></script> --}}
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Browse Properties</h2>
        <a href="{{ route('clientsFavorites') }}" class="btn btn-outline-danger">
            <i class="bi bi-heart me-1"></i> My Favorites
        </a>
    </div>

    <!-- Search Filter -->
    <form method="GET" action="{{ route('clientsListings') }}" class="mb-5 p-4 bg-white border rounded shadow-sm hover-shadow">
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
                <a href="{{ route('clientsListings') }}" class="btn btn-outline-secondary mt-2">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Property Cards -->
    <div class="row">
        @forelse($properties as $property)
            <div class="col-md-4 mb-4">
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
                        <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                            @csrf
                            <button type="submit" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                                <i class="bi {{ $property->favoredBy->contains(Auth::guard('client')->id()) ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 1.5rem; color: red;"></i>
                            </button>
                        </form>
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
                        <a href="{{ route('clientsViewProperties', $property->id) }}" class="btn btn-outline-primary mt-2">
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
                        <a href="{{ route('clientsListings') }}" class="btn btn-primary mt-2">
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
</style>


{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all favorite buttons on the page
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            
            // Disable button temporarily to prevent double clicks
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
                    
                    // Add pulse animation effect
                    button.classList.add('animate-pulse');
                    
                    // Update icon based on favorite status
                    if (data.favorited) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        button.classList.remove('animate-pulse');
                    }, 300);
                } else {
                    const errorData = await response.json();
                    console.error('Error:', errorData.error);
                    
                    // If unauthorized, redirect to login
                    if (response.status === 401) {
                        window.location.href = '/clientLogin';
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                // Re-enable button
                button.disabled = false;
            }
        });
    });
});
</script> --}}

<style>
@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.animate-pulse {
  animation: pulse 0.3s ease-in-out;
}
</style>


<script>
    /**
 * This script manages the interactive features on the property listings page
 */
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button interactions
    setupFavoriteButtons();
    
    // Optional: Add hover effects for property cards
    setupCardHoverEffects();
    
    // Optional: Add search form animations
    setupSearchFormAnimations();
});

/**
 * Configure the favorite toggle buttons
 */
function setupFavoriteButtons() {
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            
            // Disable button temporarily to prevent double clicks
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
                    
                    // Add pulse animation effect
                    button.classList.add('animate-pulse');
                    
                    // Update icon based on favorite status
                    icon.classList.toggle('bi-heart-fill', data.favorited);
                    icon.classList.toggle('bi-heart', !data.favorited);
                    
                    // Optional: Show a toast notification
                    showToastNotification(data.favorited);
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        button.classList.remove('animate-pulse');
                    }, 300);
                } else {
                    const errorData = await response.json();
                    
                    // If unauthorized, redirect to login
                    if (response.status === 401) {
                        window.location.href = '/clientLogin';
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                // Re-enable button
                button.disabled = false;
            }
        });
    });
}

function showToastNotification(isFavorited) {
    // Check if toast container exists, create if not
    let toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'favorite-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-' + (isFavorited ? 'danger' : 'secondary');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${isFavorited ? 'heart-fill' : 'heart'} me-2"></i>
                Property ${isFavorited ? 'added to' : 'removed from'} favorites
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast using Bootstrap
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}

/**
 * Add hover effects to property cards
 */
function setupCardHoverEffects() {
    // Optional: Add hover animation for property images
    document.querySelectorAll('.property-image-container img').forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Optional: Add hover effect for cards
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

/**
 * Add subtle animations to the search form
 */
function setupSearchFormAnimations() {
    const searchForm = document.querySelector('form[action*="clientsListings"]');
    
    if (searchForm) {
        // Optional: Add focus effects for form inputs
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

/**
 * Display a toast notification when favoriting/unfavoriting
 * @param {boolean} isFavorited - Whether the property was favorited
 */
function showToastNotification(isFavorited) {
    // Check if toast container exists, create if not
    let toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'favorite-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-' + (isFavorited ? 'danger' : 'secondary');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${isFavorited ? 'heart-fill' : 'heart'} me-2"></i>
                Property ${isFavorited ? 'added to' : 'removed from'} favorites
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}
</script>
@endsection