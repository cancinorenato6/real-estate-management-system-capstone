@extends('components.layout')

@section('title', 'Property Details')

@section('Content')
<div class="container mt-4">
    <h1 class="mb-4">{{ strtoupper($property->title) }}</h1>

    <div class="row">
        <div class="col-md-8">
            @if(!empty($property->images) && is_array($property->images))
                <!-- Carousel -->
                <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        @foreach($property->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="d-block w-100"
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

        <div class="col-md-4">
            <div class="border p-3 rounded">
                <h5 class="text-success">₱{{ number_format($property->price, 2) }}</h5>
                <p><strong>Offer Type:</strong> {{ ucfirst($property->offer_type) }}</p>
                <p><strong>Property Type:</strong> {{ ucfirst($property->property_type) }}</p>
                <p><strong>Location:</strong> {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}</p>
                <p><strong>Posted by:</strong> {{ $property->agent->name }}</p>

                <a href="#" class="btn btn-outline-primary w-100">Contact Agent</a>
                <div>
                    <br>
                </div>
                <a href="{{ route('listings') }}" class="btn btn-outline-secondary w-100">← Back to Listings</a>
            </div>
        </div>
    </div>

    <!-- Description Section -->
    <div class="row mt-4">
        <div class="col-12">
            <h4>Description</h4>
            <p>{{ $property->description ?? 'No description available.' }}</p>
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
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnails = document.querySelectorAll('[data-bs-target="#imageModal"]');
        thumbnails.forEach((img, index) => {
            img.addEventListener('click', () => {
                const modalCarousel = bootstrap.Carousel.getInstance(document.getElementById('modalCarousel')) || new bootstrap.Carousel(document.getElementById('modalCarousel'));
                modalCarousel.to(index);
            });
        });
    });
</script>
@endpush
