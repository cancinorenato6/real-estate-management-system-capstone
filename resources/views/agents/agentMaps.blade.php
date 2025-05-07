
@extends('components.agentLayout')

@section('title', 'Maps')

@section('Content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<style>
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
    
    /* Search form styling */
    .search-container {
        margin-bottom: 20px;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: box-shadow 0.3s ease;
    }
</style>

<div class="container py-4">

    
    <!-- Search Form -->
    <div class="search-container">
        <form id="property-search-form" method="GET" class="mb-4 p-4 bg-white border rounded shadow-sm hover-shadow">
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
                    <small class="text-muted">Enter maximum price</small>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <button type="button" id="clear-search" class="btn btn-outline-secondary mt-2">
                        <i class="bi bi-x-circle me-1"></i> Clear
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Map Container -->
    <div id="map" style="height: 500px; width: 100%; margin: 20px 0; border-radius: 8px;" class="shadow-sm"></div>
    
    <!-- Search Results Count -->
    <div class="mt-3">
        <p><span id="property-count" class="fw-bold">{{ count($properties) }}</span> properties found</p>
    </div>
</div>
  
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map
        const map = L.map('map').setView([16.615891, 120.320937], 12); // La Union coordinates

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);

        // Initialize marker cluster group
        let markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
        });

        // Get properties from Laravel
        const properties = @json($properties);
        
        // Function to render markers
        function renderMarkers(propertiesToRender) {
            // Clear existing markers
            markers.clearLayers();
            
            // Update property count
            document.getElementById('property-count').textContent = propertiesToRender.length;
            
            // Add markers for each property
            propertiesToRender.forEach(property => {
                if (property.latitude && property.longitude) {
                    const popupContent = `
                        <div class="map-popup">
                            <h5>${property.title}</h5>
                            <p><strong>₱${parseFloat(property.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</strong></p>
                            <p>${property.barangay}, ${property.city}, ${property.province}</p>
                            <p>${property.offer_type.charAt(0).toUpperCase() + property.offer_type.slice(1)} | 
                               ${property.property_type.charAt(0).toUpperCase() + property.property_type.slice(1)}</p>
                            <a href="{{ url('/viewProperties') }}/${property.id}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    `;
                    const marker = L.marker([property.latitude, property.longitude])
                        .bindPopup(popupContent, { maxWidth: 300 });

                    // Store property ID for interaction
                    marker.propertyId = property.id;
                    markers.addLayer(marker);
                }
            });

            // Add marker cluster group to map
            map.addLayer(markers);

            // Fit map to bounds if there are markers
            if (markers.getLayers().length > 1) {
                map.fitBounds(markers.getBounds().pad(0.2));
            } else if (markers.getLayers().length === 1) {
                map.setView(markers.getLayers()[0].getLatLng(), 14);
            }
        }

        // Initial render
        renderMarkers(properties);

        // Handle form submission
        document.getElementById('property-search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const location = document.getElementById('location').value;
            const propertyType = document.getElementById('property_type').value;
            const maxPrice = document.getElementById('price').value;
            
            // Filter properties based on form values
            let filteredProperties = properties.filter(property => {
                let matchesLocation = true;
                let matchesType = true;
                let matchesPrice = true;
                
                // Location filter
                if (location) {
                    const locationLower = location.toLowerCase();
                    matchesLocation = property.barangay.toLowerCase().includes(locationLower) || 
                                      property.city.toLowerCase().includes(locationLower) || 
                                      property.province.toLowerCase().includes(locationLower);
                }
                
                // Property type filter
                if (propertyType) {
                    matchesType = property.property_type === propertyType;
                }
                
                // Price filter
                if (maxPrice) {
                    matchesPrice = parseFloat(property.price) <= parseFloat(maxPrice);
                }
                
                return matchesLocation && matchesType && matchesPrice;
            });
            
            // Update the URL with the search parameters (for browser history)
            const url = new URL(window.location);
            if (location) url.searchParams.set('location', location);
            else url.searchParams.delete('location');
            
            if (propertyType) url.searchParams.set('property_type', propertyType);
            else url.searchParams.delete('property_type');
            
            if (maxPrice) url.searchParams.set('price', maxPrice);
            else url.searchParams.delete('price');
            
            window.history.pushState({}, '', url);
            
            // Render the filtered markers
            renderMarkers(filteredProperties);
        });
        
        // Handle clear button
        document.getElementById('clear-search').addEventListener('click', function() {
            // Clear form inputs
            document.getElementById('location').value = '';
            document.getElementById('property_type').value = '';
            document.getElementById('price').value = '';
            
            // Reset URL
            window.history.pushState({}, '', window.location.pathname);
            
            // Reset markers to show all properties
            renderMarkers(properties);
        });
        
        // Load initial search parameters from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('location') || urlParams.has('property_type') || urlParams.has('price')) {
            // Trigger search with URL parameters
            document.getElementById('property-search-form').dispatchEvent(new Event('submit'));
        }
    });
</script>
@endsection