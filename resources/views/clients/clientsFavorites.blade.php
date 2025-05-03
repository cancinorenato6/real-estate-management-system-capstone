@extends('components.clientLayout')

@section('title', 'My Favorites')

@section('Content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            My Favorite Properties 
            @if($favorites->count())
                <span class="badge bg-danger rounded-pill favorites-count">{{ $favorites->count() }}</span>
            @endif
        </h2>
        <a href="{{ route('clientsListings') }}" class="btn btn-outline-primary">
            <i class="bi bi-search me-1"></i> Browse More
        </a>
    </div>

    @if($favorites->count())
        <div class="row">
            @foreach ($favorites as $property)
                <div class="col-md-4 mb-4 favorite-item" data-property-id="{{ $property->id }}">
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
                        @if(!empty($property->images) && is_array($property->images))
                            <div class="property-image-container" style="height: 200px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-house" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 end-0 m-2">
                            <form method="POST" action="{{ route('favoriteProperty', $property->id) }}" class="favorite-form">
                                @csrf
                                <button type="submit" class="btn btn-light p-1 favorite-btn" style="border-radius: 50%;">
                                    <i class="bi bi-heart-fill" style="font-size: 1.3rem; color: red;"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Property Details -->
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-success">{{ strtoupper($property->title) }}</h5>
                                <p class="card-text mb-2">
                                    <strong class="text-primary">₱{{ number_format($property->price, 2) }}</strong><br>
                                    <span class="badge bg-secondary me-1">{{ ucfirst($property->offer_type) }}</span>
                                    <span class="badge bg-info">{{ ucfirst($property->property_type) }}</span>
                                </p>
                                <p class="card-text">
                                    <i class="bi bi-geo-alt"></i> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}
                                </p>
                            </div>
                            <a href="{{ route('clientsViewProperties', $property->id) }}" class="btn btn-outline-primary mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="alert alert-info text-center p-5">
            <i class="bi bi-heart" style="font-size: 3rem;"></i>
            <h4 class="mt-3">You haven't favorited any properties yet</h4>
            <p class="text-muted">Find properties you like and click the heart icon to add them to your favorites</p>
            <div class="mt-3">
                <a href="{{ route('clientsListings') }}" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Browse Properties
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: all 0.3s ease;
    }
    .card {
        transition: all 0.3s ease;
    }
    .favorites-count {
        font-size: 0.8rem;
        vertical-align: top;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all favorite buttons on the page
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const card = form.closest('.col-md-4');
            const button = form.querySelector('button');
            
            // Add visual feedback during the request
            button.disabled = true;
            card.style.transition = 'opacity 0.3s';
            card.style.opacity = '0.5';
            
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
                    
                    // If property was unfavorited, remove the property card with animation
                    if (!data.favorited) {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        
                        setTimeout(() => {
                            card.remove();
                            
                            // Update the counter
                            const favoritesCount = document.querySelector('.favorites-count');
                            const remainingCards = document.querySelectorAll('.favorite-item').length;
                            
                            if (favoritesCount) {
                                if (remainingCards === 0) {
                                    // Hide counter when zero
                                    favoritesCount.style.display = 'none';
                                    
                                    // Show no favorites message
                                    showNoFavoritesMessage();
                                } else {
                                    // Update counter
                                    favoritesCount.textContent = remainingCards;
                                }
                            }
                        }, 300);
                    } else {
                        // This should not happen on favorites page, but reset if it does
                        card.style.opacity = '1';
                        button.disabled = false;
                    }
                } else {
                    // Reset the card on error
                    card.style.opacity = '1';
                    button.disabled = false;
                    
                    // If unauthorized, redirect to login
                    if (response.status === 401) {
                        window.location.href = '/clientLogin';
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
                // Reset the card
                card.style.opacity = '1';
                button.disabled = false;
            }
        });
    });
    
    /**
     * Show a message when no favorites remain
     */
    function showNoFavoritesMessage() {
        const container = document.querySelector('.container');
        const row = document.querySelector('.row');
        
        if (container && row) {
            // Create fade out animation
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';
            
            setTimeout(() => {
                // Remove existing content
                row.remove();
                
                // Create no favorites message
                const noFavoritesMessage = document.createElement('div');
                noFavoritesMessage.className = 'alert alert-info text-center p-5';
                noFavoritesMessage.style.opacity = '0';
                noFavoritesMessage.innerHTML = `
                    <i class="bi bi-heart" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">You haven't favorited any properties yet</h4>
                    <p class="text-muted">Find properties you like and click the heart icon to add them to your favorites</p>
                    <div class="mt-3">
                        <a href="{{ route('clientsListings') }}" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Browse Properties
                        </a>
                    </div>
                `;
                
                // Remove pagination if it exists
                const pagination = document.querySelector('.d-flex.justify-content-center.mt-4');
                if (pagination) {
                    pagination.remove();
                }
                
                // Add the message to container
                container.appendChild(noFavoritesMessage);
                
                // Trigger reflow/repaint before adding the transition
                void noFavoritesMessage.offsetWidth;
                
                // Add fade in animation
                noFavoritesMessage.style.transition = 'opacity 0.5s ease';
                noFavoritesMessage.style.opacity = '1';
            }, 500);
        }
    }
});
</script>

@endsection