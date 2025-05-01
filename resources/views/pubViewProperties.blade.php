@extends('components.layout')

@section('title', 'Property Details')

@section('Content')
<div class="container mt-4">
    <h1 class="mb-3 text-uppercase fw-bold">{{ $property->title }}</h1>

    <div class="row g-4">
        <!-- Left Column: Images -->
        <div class="col-lg-8">
            @if(!empty($property->images) && is_array($property->images))
                <div id="propertyCarousel" class="carousel slide rounded shadow-sm" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        @foreach($property->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="d-block w-100 rounded" 
                                     style="height: 400px; object-fit: cover; cursor: pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     data-index="{{ $index }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Right Column: Info -->
        <div class="col-lg-4">
            <div class="border p-4 rounded shadow-sm bg-light">
                <h4 class="text-success fw-bold mb-3">₱{{ number_format($property->price, 2) }}</h4>
                <ul class="list-unstyled">
                    <li><strong>Offer Type:</strong> {{ ucfirst($property->offer_type) }}</li>
                    <li><strong>Property Type:</strong> {{ ucfirst($property->property_type) }}</li>
                    <li><strong>Location:</strong> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}</li>
                    <li><strong>Posted by:</strong> {{ $property->agent->name }}</li>
                </ul>

                <div class="d-grid gap-2 mt-3">
                    @guest
                    <a href="{{ route('login') }}?login_required=true" class="btn btn-outline-primary">Contact Agent</a>

                    @endguest
                   
                    <a href="{{ route('listings') }}" class="btn btn-outline-secondary">← Back to Listings</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-3">Description</h4>
            <div class="bg-white p-3 rounded shadow-sm border">
                <p class="mb-0">{{ $property->description ?? 'No description available.' }}</p>
            </div>
        </div>
    </div>

    <!-- Modal Fullscreen Carousel -->
    @if(!empty($property->images) && is_array($property->images))
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($property->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" style="height: 90vh; object-fit: contain;">
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
</div>

@endsection

