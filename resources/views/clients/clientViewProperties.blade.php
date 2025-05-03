@extends('components.clientLayout')

@section('title', 'View Property')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-4">
    <!-- Page Header with Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Property Details</h2>
        <div>
            <a href="{{ route('clientsFavorites') }}" class="btn btn-outline-danger me-2">
                <i class="bi bi-heart me-1"></i> My Favorites
            </a>
            <a href="{{route('clientsListings')}}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Listings
            </a>
        </div>
    </div>

    <!-- Property Title Card -->
    <div class="card mb-4 shadow-sm hover-shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0 text-uppercase fw-bold">{{ $property->title }}</h1>
                
                <!-- Favorite Button -->
                <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                    @csrf
                    <button type="submit" class="btn btn-light p-2 favorite-btn" style="border-radius: 50%;">
                        <i class="bi {{ $property->favoredBy->contains(Auth::guard('client')->id()) ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 1.5rem; color: red;"></i>
                    </button>
                </form>
            </div>
            
            <p class="text-muted mb-0">
                <i class="bi bi-geo-alt-fill"></i> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
            </p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Images -->
        <div class="col-lg-8">
            @if(!empty($property->images) && is_array($property->images))
                <div id="propertyCarousel" class="carousel slide rounded shadow-sm hover-shadow" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        @foreach($property->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         class="d-block w-100 rounded property-img" 
                                         style="height: 500px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;"
                                         data-index="{{ $index }}">
                                    
                                    <!-- Image Counter -->
                                    <div class="position-absolute bottom-0 end-0 m-3 bg-dark bg-opacity-75 px-3 py-1 rounded text-white">
                                        <small>{{ $index + 1 }} / {{ count($property->images) }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    
                    <!-- Thumbnail Navigation -->
                    <div class="d-flex justify-content-center mt-2">
                        @foreach($property->images as $index => $image)
                            <div class="mx-1" style="width: 60px; height: 45px; cursor: pointer;">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="img-thumbnail {{ $index === 0 ? 'border-primary' : '' }}"
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     data-index="{{ $index }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Property Info Cards -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm hover-shadow">
                            <div class="card-header bg-white">
                                <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>Description</h4>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $property->description ?? 'No description available.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Right Column: Info -->
        <div class="col-lg-4">
            <!-- Price and Features Card -->
            <div class="card mb-4 shadow-sm hover-shadow">
                <div class="card-header bg-white">
                    <h4 class="text-success fw-bold mb-0"><i class="bi bi-cash me-2"></i>₱{{ number_format($property->price, 2) }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-primary mb-2 me-1">{{ ucfirst($property->offer_type) }}</span>
                        <span class="badge bg-info mb-2">{{ ucfirst($property->property_type) }}</span>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-geo-alt me-2"></i>Location</span>
                            <span class="text-muted">{{ $property->barangay }}, {{ $property->city }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-pin-map me-2"></i>Province</span>
                            <span class="text-muted">{{ $property->province }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar-date me-2"></i>Posted</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($property->created_at)->format('M d, Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Agent Info Card -->
            <div class="card shadow-sm hover-shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Agent Information</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                             alt="Agent profile"
                             class="rounded-circle me-3"
                             width="70" height="70"
                             style="object-fit: cover;">
                        <div>
                            <h5 class="mb-1">{{ $property->agent->name }}</h5>
                            <p class="text-muted mb-0"><i class="bi bi-telephone me-1"></i> {{ $property->agent->phone ?? 'Contact via email' }}</p>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $property->agent->email }}" class="btn btn-primary">
                            <i class="bi bi-envelope me-1"></i> Email Agent
                        </a>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-chat-dots me-1"></i> Contact Agent
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Similar Properties Card (Optional) -->
            <div class="card mt-4 shadow-sm hover-shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-houses me-2"></i>You May Also Like</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($similarProperties ?? [] as $similar)
                            <li class="list-group-item">
                                <a href="{{ route('clientsViewProperties', $similar->id) }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 60px; height: 60px;" class="me-2">
                                            @if(!empty($similar->images) && is_array($similar->images))
                                                <img src="{{ asset('storage/' . $similar->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                    <i class="bi bi-house" style="font-size: 1.5rem; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate" style="max-width: 200px;">{{ $similar->title }}</h6>
                                            <small class="text-success">₱{{ number_format($similar->price, 2) }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        @if(empty($similarProperties ?? []))
                            <li class="list-group-item text-center text-muted py-4">
                                <i class="bi bi-house-x mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">No similar properties found</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Fullscreen Carousel -->
    @if(!empty($property->images) && is_array($property->images))
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white">Property Images</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($property->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 90vh;">
                                            <img src="{{ asset('storage/' . $image) }}" class="d-block" style="max-height: 90vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $property->title }}</h5>
                                            <p>Image {{ $index + 1 }} of {{ count($property->images) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    
    <!-- Contact Agent Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Contact Agent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contactAgentForm">
                        <div class="mb-3">
                            <label for="message-subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="message-subject" placeholder="Inquiry about {{ $property->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="form-label">Message</label>
                            <textarea class="form-control" id="message-text" rows="5" placeholder="I am interested in this property and would like more information..."></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="contactConsent">
                            <label class="form-check-label" for="contactConsent">I consent to receiving communications from this agent</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="sendMessageBtn">
                        <i class="bi bi-send me-1"></i> Send Message
                    </button>
                </div>
            </div>
        </div>
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
    .property-img:hover {
        transform: scale(1.02);
    }
    .favorite-btn:hover {
        background-color: rgba(255, 0, 0, 0.1);
    }
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 10px;
    }
    
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
    // Initialize Bootstrap carousels
    const propertyCarousel = document.getElementById('propertyCarousel');
    const modalCarousel = document.getElementById('modalCarousel');
    
    if (propertyCarousel) {
        new bootstrap.Carousel(propertyCarousel);
    }
    
    if (modalCarousel) {
        new bootstrap.Carousel(modalCarousel);
    }

    // Handle thumbnail clicks (without using jQuery)
    document.querySelectorAll('.img-thumbnail').forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            // Update thumbnail selection visual
            document.querySelectorAll('.img-thumbnail').forEach(t => t.classList.remove('border-primary'));
            this.classList.add('border-primary');
            
            // Move carousel to this index
            if (propertyCarousel) {
                const carousel = bootstrap.Carousel.getInstance(propertyCarousel);
                if (carousel) {
                    carousel.to(index);
                } else {
                    new bootstrap.Carousel(propertyCarousel).to(index);
                }
            }
        });
    });
    
    // Make main carousel images open the modal
    document.querySelectorAll('.property-img').forEach((img) => {
        img.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
            
            // Set modal carousel to correct slide after modal is shown
            document.getElementById('imageModal').addEventListener('shown.bs.modal', function() {
                if (modalCarousel && index) {
                    const modalCarouselInstance = bootstrap.Carousel.getInstance(modalCarousel) || 
                        new bootstrap.Carousel(modalCarousel);
                    modalCarouselInstance.to(parseInt(index));
                }
            }, { once: true }); // Use once to prevent multiple listeners
        });
    });
    
    // Synchronize modal carousel with main carousel
    if (propertyCarousel) {
        propertyCarousel.addEventListener('slide.bs.carousel', function(event) {
            const slideIndex = event.to;
            
            // Update thumbnails
            document.querySelectorAll('.img-thumbnail').forEach((thumb, idx) => {
                thumb.classList.toggle('border-primary', idx === slideIndex);
            });
            
            // Sync with modal carousel if it's visible
            if (modalCarousel && document.getElementById('imageModal').classList.contains('show')) {
                const modalCarouselInstance = bootstrap.Carousel.getInstance(modalCarousel);
                if (modalCarouselInstance) {
                    modalCarouselInstance.to(slideIndex);
                }
            }
        });
    }
    
    // Add favorite button functionality
    document.querySelector('.favorite-form')?.addEventListener('submit', async function(e) {
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
                    showToastNotification(true);
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    showToastNotification(false);
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
    
    // Handle contact form submission (demo)
    document.getElementById('sendMessageBtn')?.addEventListener('click', function() {
        const subject = document.getElementById('message-subject').value;
        const message = document.getElementById('message-text').value;
        const consent = document.getElementById('contactConsent').checked;
        
        if (!subject || !message) {
            alert('Please fill in all fields');
            return;
        }
        
        if (!consent) {
            alert('Please provide your consent to contact the agent');
            return;
        }
        
        // Here you would normally send an AJAX request to your backend
        // For demo purposes, we'll just show a success message
        
        // Close the modal
        bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
        
        // Show success toast
        showContactSuccessToast();
    });
});

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
 * Display a success toast when contacting an agent
 */
function showContactSuccessToast() {
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
    const toastId = 'contact-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-success';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                Message sent successfully! The agent will contact you soon.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 5000
    });
    
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}
</script>

@endsection