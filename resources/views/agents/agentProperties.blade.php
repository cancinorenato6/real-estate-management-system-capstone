{{-- @extends('components.agentLayout')

@section('title', 'Agent Properties')

@section('Content')

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
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
                    <!-- Agent Info -->
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

                        <form action="{{ route('property.archive', $property->id) }}" method="POST" class="d-inline archive-form">
                            @csrf
                            <button type="button" class="btn btn-outline-primary btn-sm archive-btn">Archive</button>
                        </form>

                        <a href="#" class="btn btn-outline-primary btn-sm">Sold</a>
                    </div>
                </div>  
            </div>
        @empty
            <p>No properties found.</p>
        @endforelse
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.archive-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.archive-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This property will be archived!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection



 --}}
{{-- @extends('components.agentLayout')

@section('title', 'Agent Properties')

@section('Content')

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
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
                    <!-- Agent Info -->
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

                        <form action="{{ route('property.archive', $property->id) }}" method="POST" class="d-inline archive-form">
                            @csrf
                            <button type="button" class="btn btn-outline-primary btn-sm archive-btn">Archive</button>
                        </form>

                        <a href="#" class="btn btn-outline-primary btn-sm">Sold</a>
                    </div>
                </div>  
            </div>
        @empty
            <p>No properties found.</p>
        @endforelse
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.archive-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.archive-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This property will be archived!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection



 --}}
 @extends('components.agentLayout')

 @section('title', 'Agent Properties')
 
 @section('Content')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
 <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
 <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
 
 @if(session('success'))
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
         document.addEventListener('DOMContentLoaded', function () {
             Swal.fire({
                 toast: true,
                 position: 'top-end',
                 icon: 'success',
                 title: '{{ session('success') }}',
                 showConfirmButton: false,
                 timer: 3000,
                 timerProgressBar: true
             });
         });
     </script>
 @endif
 
 <div class="container py-4">
     <!-- Page Header -->
     <div class="d-flex justify-content-between align-items-center mb-4">
         <h2>Your Posted Properties</h2>
         <a href="{{ route('createProperty') }}" class="btn btn-primary">
             <i class="bi bi-plus-circle me-2"></i> Add Property
         </a>
     </div>
 
     <!-- Map Container -->
     <div class="card mb-4 shadow-sm">
         <div class="card-header bg-light d-flex justify-content-between align-items-center">
             <h5 class="mb-0">
                 <i class="bi bi-geo-alt-fill me-2"></i> Your Properties Map
             </h5>
             <div class="badge bg-primary" id="map-counter">
                 {{ count($properties) }} Properties Listed
             </div>
         </div>
         <div class="card-body p-0">
             <div id="property-map" style="height: 400px; width: 100%; border-radius: 0 0 0.25rem 0.25rem;"></div>
         </div>
     </div>
 
     <!-- View Toggle -->
     <div class="mb-3 d-flex justify-content-between align-items-center">
         <h4>Manage Your Properties</h4>
         <div class="btn-group" role="group">
             <button type="button" class="btn btn-outline-primary active" id="grid-view-btn">
                 <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
             </button>
             <button type="button" class="btn btn-outline-primary" id="list-view-btn">
                 <i class="bi bi-list-ul me-1"></i> List
             </button>
         </div>
     </div>
 
     <!-- Property Cards Grid View -->
     <div class="row" id="grid-view">
         @forelse($properties as $property)
             <div class="col-md-4 mb-4 property-card" data-property-id="{{ $property->id }}">
                 <div class="card h-100 shadow-sm hover-shadow">
                     <!-- Agent Info -->
                     <div class="d-flex align-items-center p-2 bg-light border-bottom">
                         <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                              alt="Agent profile"
                              class="rounded-circle me-2"
                              width="40"
                              height="40"
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
                         <div class="d-flex gap-2 mt-2">
                             <a href="{{ route('viewProperties', $property->id) }}" class="btn btn-outline-primary flex-grow-1">
                                 <i class="bi bi-eye me-1"></i> View
                             </a>
                             <form action="{{ route('property.archive', $property->id) }}" method="POST" class="archive-form flex-grow-1">
                                 @csrf
                                 <button type="button" class="btn btn-outline-warning w-100 archive-btn">
                                     <i class="bi bi-archive me-1"></i> Archive
                                 </button>
                             </form>
                             
                             <button type="button" class="btn btn-outline-success mark-sold-btn" data-property-id="{{ $property->id }}">
                                 <i class="bi bi-check-circle me-1"></i> Sold
                             </button>
                         </div>
                     </div>
                 </div>  
             </div>
         @empty
             <div class="col-12">
                 <div class="alert alert-info text-center p-5">
                     <i class="bi bi-house-x" style="font-size: 3rem;"></i>
                     <h4 class="mt-3">No properties posted yet</h4>
                     <p class="text-muted">
                         You haven't posted any properties. Click the button below to add your first property.
                     </p>
                     <a href="{{ route('createProperty') }}" class="btn btn-primary mt-2">
                         <i class="bi bi-plus-circle me-1"></i> Add Property
                     </a>
                 </div>
             </div>
         @endforelse
     </div>
 
     <!-- Property Cards List View -->
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
                                                 <small class="text-muted">Posted on {{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}</small>
                                             </div>
                                         </div>
                                         <div class="ms-auto align-self-center d-flex gap-2">
                                             <a href="{{ route('viewProperties', $property->id) }}" class="btn btn-outline-primary">
                                                 <i class="bi bi-eye me-1"></i> View
                                             </a>
                                             <form action="{{ route('property.archive', $property->id) }}" method="POST" class="archive-form">
                                                 @csrf
                                                 <button type="button" class="btn btn-outline-warning archive-btn">
                                                     <i class="bi bi-archive me-1"></i> Archive
                                                 </button>
                                             </form>
                                             <button type="button" class="btn btn-outline-success mark-sold-btn" data-property-id="{{ $property->id }}">
                                                 <i class="bi bi-check-circle me-1"></i> Sold
                                             </button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 @empty
                     <div class="list-group-item">
                         <div class="alert alert-info text-center p-4">
                             <i class="bi bi-house-x" style="font-size: 2rem;"></i>
                             <h5 class="mt-3">No properties posted yet</h5>
                             <p class="text-muted">
                                 You haven't posted any properties. Click the button below to add your first property.
                             </p>
                             <a href="{{ route('createProperty') }}" class="btn btn-primary mt-2">
                                 <i class="bi bi-plus-circle me-1"></i> Add Property
                             </a>
                         </div>
                     </div>
                 @endforelse
             </div>
         </div>
     </div>
 
     <!-- Pagination if needed -->
     @if($properties instanceof \Illuminate\Pagination\LengthAwarePaginator && $properties->hasPages())
     <div class="d-flex justify-content-center mt-4">
         {{ $properties->links() }}
     </div>
     @endif
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
     .map-popup {
         text-align: center;
     }
     .map-popup img {
         max-width: 100%;
         height: 120px;
         object-fit: cover;
         border-radius: 4px;
         margin-bottom: 10px;
     }
     .map-popup h5 {
         margin: 5px 0;
         color: #2c3e50;
     }
     .map-popup .price {
         font-weight: bold;
         color: #3498db;
         margin-bottom: 5px;
     }
     .map-popup .location {
         font-size: 0.9rem;
         margin-bottom: 8px;
     }
     .map-popup .btn {
         margin-top: 5px;
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
         .btn-group .btn {
             padding: 0.25rem 0.5rem;
         }
     }
 </style>
 
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
 <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
 
 <script>
 document.addEventListener('DOMContentLoaded', function () {
     // Initialize view toggle
     setupViewToggle();
     
     // Initialize map if properties exist
     initializePropertyMap();
     
     // Initialize archive buttons
     setupArchiveButtons();
     
     // Initialize sold buttons
     setupSoldButtons();
     
     // Setup card hover effects
     setupCardHoverEffects();
 });
document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.archive-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.archive-form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This property will be archived!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
 
 function setupSoldButtons() {
     document.querySelectorAll('.mark-sold-btn').forEach(button => {
         button.addEventListener('click', function() {
             const propertyId = this.getAttribute('data-property-id');
             Swal.fire({
                 title: 'Mark as sold?',
                 text: "This property will be marked as sold and no longer listed!",
                 icon: 'question',
                 showCancelButton: true,
                 confirmButtonColor: '#28a745',
                 cancelButtonColor: '#6c757d',
                 confirmButtonText: 'Yes, it\'s sold!'
             }).then((result) => {
                 if (result.isConfirmed) {
                     // Replace with your actual route for marking as sold
                     const soldForm = document.createElement('form');
                     soldForm.method = 'POST';
                     soldForm.action = '/property/sold/' + propertyId; // Update with actual route
                     soldForm.style.display = 'none';
                     
                     const csrfToken = document.createElement('input');
                     csrfToken.type = 'hidden';
                     csrfToken.name = '_token';
                     csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                     
                     soldForm.appendChild(csrfToken);
                     document.body.appendChild(soldForm);
                     soldForm.submit();
                 }
             });
         });
     });
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
         localStorage.setItem('agentPropertyViewPreference', 'grid');
     });
     
     listViewBtn.addEventListener('click', function() {
         gridView.classList.add('d-none');
         listView.classList.remove('d-none');
         gridViewBtn.classList.remove('active');
         listViewBtn.classList.add('active');
         
         // Store preference in local storage
         localStorage.setItem('agentPropertyViewPreference', 'list');
     });
     
     // Check user's saved preference
     const savedViewPreference = localStorage.getItem('agentPropertyViewPreference');
     if (savedViewPreference === 'list') {
         listViewBtn.click();
     }
 }
 
 function setupCardHoverEffects() {
     document.querySelectorAll('.property-image-container img').forEach(img => {
         img.addEventListener('mouseenter', function() { this.style.transform = 'scale(1.05)'; });
         img.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; });
     });
 }
 
 function initializePropertyMap() {
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
    
    const defaultCoords = [16.615891, 120.320937];
    let centerLat, centerLng;
    
    if (properties.length > 0 && properties[0].latitude && properties[0].longitude) {
        centerLat = properties[0].latitude;
        centerLng = properties[0].longitude;
    } else {
        [centerLat, centerLng] = defaultCoords;
    }
    
    const map = L.map('property-map').setView([centerLat, centerLng], 12);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map);
    
    const markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: true,
        zoomToBoundsOnClick: true
    });
    
    const markersByPropertyId = {};
    
    properties.forEach(property => {
        if (property.latitude && property.longitude) {
            let imageHtml;
            if (property.images && property.images.length > 0) {
                imageHtml = `<img src="{{ asset('storage') }}/${property.images[0]}" alt="${property.title}">`;
            } else {
                imageHtml = `<div class="bg-light text-center py-3"><i class="bi bi-house" style="font-size: 2rem; color: #ccc;"></i></div>`;
            }
            
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
                    <a href="{{ url('/viewProperties') }}/${property.id}" class="btn btn-sm btn-primary w-100">View Post</a>

                     
                 
                </div>
            `;
            
            const marker = L.marker([property.latitude, property.longitude])
                .bindPopup(popupContent, { maxWidth: 300 });
            
            marker.propertyId = property.id;
            markers.addLayer(marker);
            markersByPropertyId[property.id] = marker;
        }
    });
    
    map.addLayer(markers);
    
    if (markers.getLayers().length > 1) {
        map.fitBounds(markers.getBounds().pad(0.2));
    } else if (markers.getLayers().length === 1) {
        map.setView(markers.getLayers()[0].getLatLng(), 14);
    }
    
    document.querySelectorAll('.property-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || 
                e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            
            const propertyId = this.dataset.propertyId;
            const marker = markersByPropertyId[propertyId];
            
            if (marker) {
                const mapElement = document.getElementById('property-map');
                const mapRect = mapElement.getBoundingClientRect();
                
                if (mapRect.top < 0 || mapRect.bottom > window.innerHeight) {
                    mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                map.setView(marker.getLatLng(), 15);
                marker.openPopup();
            }
        });
    });
    
    document.getElementById('map-counter').textContent = `${properties.length} Properties Found`;
}
 </script>
 @endsection