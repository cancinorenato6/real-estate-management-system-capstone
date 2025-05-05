@extends('components.layout')

@section('title', 'Home')



@section('Content')

<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div id="home" class="hero">
    <div class="hero-content">
      <h1>Find Your Dream Home with Canaanland</h1>
      <p>Connecting property buyers, owners, and tenants with ease.</p>
      <form method="GET" action="{{ route('listings') }}" class="search-bar">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
            <input type="text" name="location" placeholder="Location" class="form-control">
        </div>
        
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-house"></i></span>
            <select name="property_type" class="form-select">
                <option disabled selected hidden>Property Type</option>
                <option value="">Any</option>
                <option value="condominium">Condominium</option>
                <option value="commercial_space">Commercial Space</option>
                <option value="apartment">Apartment</option>
                <option value="house">House</option>
                <option value="land">Land</option>
            </select>
        </div>
        
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-cash"></i></span>
            <input type="number" name="price" placeholder="Max Price" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search me-1"></i> Search
        </button>
    </form>
    </div>
</div>
<div>
    <br>
</div>


<div id="listings" class="section container py-4">
    <h2 class="text-center" style="color: #2c3e50;">Featured Listings in La Union</h2>
    <div class="d-flex justify-content-between align-items-center mb-4">
        @auth
            <a href="{{ route('favorites') }}" class="btn btn-outline-danger">
                <i class="bi bi-heart me-1"></i> My Favorites
            </a>
        @endauth
    </div>
</div>
    
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
                            <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" 
                                 style="object-fit: cover; height: 100%; width: 100%; transition: transform 0.3s ease;">
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
                                    <i class="bi {{ $property->favoredBy->contains(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}" 
                                       style="font-size: 1.5rem; color: red;"></i>
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
                    <p class="text-muted">No properties are available at the moment. Please check back later.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- View All Properties Button -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('listings') }}" class="btn btn-primary">
            <i class="bi bi-grid-3x3-gap me-1"></i> View All Properties
        </a>
    </div>
</div>

<!-- Map Section -->
<div class="section container py-4">
    <h2 style="color: #2c3e50">Explore Properties in La Union</h2>
    <div id="map" style="height: 500px; width: 100%; margin: 20px 0; border-radius: 8px;" class="shadow-sm"></div>
</div>

<!-- Why Choose Us Section -->
<div class="why-choose-us-section container py-5">
    <h2 class="section-title text-center mb-4">WHY CHOOSE US?</h2>
    
    <p class="section-subtitle text-center mb-5">Canaanland Realty Corporation is a SEC Registered company that mainly provides real estate services. Located at San Fernando City, La Union.</p>
    
    <div class="row features-container">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="feature-card text-center p-4 shadow-sm hover-shadow h-100">
                <i class="bi bi-house-check mb-3" style="font-size: 2.5rem; color: #2c3e50;"></i>
                <h3>Extensive Listings</h3>
                <p>Discover a wide range of properties across La Union</p>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="feature-card text-center p-4 shadow-sm hover-shadow h-100">
                <i class="bi bi-bar-chart-line mb-3" style="font-size: 2.5rem; color: #2c3e50;"></i>
                <h3>Easy Comparison</h3>
                <p>Effortlessly compare properties to find your perfect match</p>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="feature-card text-center p-4 shadow-sm hover-shadow h-100">
                <i class="bi bi-shield-check mb-3" style="font-size: 2.5rem; color: #2c3e50;"></i>
                <h3>Reliable Service</h3>
                <p>Experience trustworthy support throughout your property journey</p>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="feature-card text-center p-4 shadow-sm hover-shadow h-100">
                <i class="bi bi-geo-alt mb-3" style="font-size: 2.5rem; color: #2c3e50;"></i>
                <h3>Local Expertise</h3>
                <p>Benefit from our team's in-depth knowledge of the La Union market</p>
            </div>
        </div>
    </div>
</div>

<!-- Map Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map
        const map = L.map('map').setView([16.6162, 120.3172], 12); // Centered on La Union

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const properties = @json($properties);

        properties.forEach(property => {
            if (property.latitude && property.longitude) {
                const popupContent = `
                    <div class="map-popup">
                        <h5>${property.title}</h5>
                        <p><strong>₱${parseFloat(property.price).toLocaleString()}</strong></p>
                        <p>${property.offer_type} | ${property.property_type}</p>
                        <button onclick="window.location.href='/property/${property.id}'" class="btn btn-sm btn-primary">View Details</button>
                    </div>
                `;
                L.marker([property.latitude, property.longitude]).addTo(map)
                    .bindPopup(popupContent);
            }
        });
    });
</script>

<!-- Favorites and Card Animation Scripts -->
<style>
    /* Hover Effects */
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
     /* Feature Cards */
     .feature-card {
        background: white;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .search-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        /* background: rgba(255,255,255,0.2); */
        padding: 20px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .search-bar .input-group {
        flex: 1;
        min-width: 150px;
    }
    
    .search-bar button {
        padding: 10px 25px;
        font-weight: 600;
    }

    .search-bar button:hover{
        background-color: #E76F51;
    }


    /* Map Popup Styling */
    .map-popup {
        text-align: center;
        min-width: 200px;
    }
    
    .map-popup h5 {
        margin-bottom: 8px;
        color: #2c3e50;
    }
    
    .map-popup p {
        margin-bottom: 8px;
    }
    
    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
    
    /* Animation for Favorites */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .animate-pulse {
        animation: pulse 0.3s ease-in-out;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.2rem;
        }
        .hero p {
            font-size: 1.1rem;
        }
        .search-bar {
            flex-direction: column;
        }
        .search-bar .input-group,
        .search-bar button {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setupFavoriteButtons();
    setupCardHoverEffects();
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

    document.querySelectorAll('.card, .feature-card').forEach(card => {
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
</script>
@endsection
