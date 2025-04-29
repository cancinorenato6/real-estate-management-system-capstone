@extends('components.agentLayout')

@section('title', 'Property Details')

@section('Content')
<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <a href="{{ route('agentProperties') }}" class="btn btn-secondary mb-3">← Back to Listings</a>
    <a href="{{ route('editProperty', ['id' => $property->id]) }}" class="btn btn-primary mb-3 float-end">
        ✏️ Edit Property
    </a>



    <div class="card">
        @if (!empty($property->images) && is_array($property->images))
        <!-- Display Carousel -->
        <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($property->images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img 
                        src="{{ asset('storage/' . $image) }}" 
                        class="d-block w-100 preview-image" 
                        style="height: 300px; object-fit: cover; cursor: pointer;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#imageModal" 
                        data-index="{{ $index }}"
                    >
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

        <!-- Modal with Fullscreen Carousel -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark text-white position-relative">
                    <div class="modal-body p-0">
                        <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($property->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img 
                                        src="{{ asset('storage/' . $image) }}" 
                                        class="d-block w-100" 
                                        style="height: 600px; object-fit: contain;">
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
                    <!-- Functional Close Button -->
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- Property Details -->
        <div class="card-body">
            <h3 class="text-success">{{ strtoupper($property->title) }}</h3>
            <p>
                <strong>₱{{ number_format($property->price, 2) }}</strong><br>
                {{ ucfirst($property->offer_type) }} | {{ ucfirst($property->property_type) }}<br>
                📍 {{ $property->barangay }}, {{ $property->city }}, {{ $property->province }}<br>
                🏡 {{ $property->description }}
            </p>

            <hr>
            <h5>Agent Information</h5>
            <div class="d-flex align-items-center mt-2">
                <img src="{{ $property->agent->profile_pic ? asset('storage/' . $property->agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}"
                     alt="Agent"
                     class="rounded-circle me-2"
                     width="50"
                     height="50"
                     style="object-fit: cover;">
                <div>
                    <strong>{{ $property->agent->name }}</strong><br>
                    <small class="text-muted">Posted: {{ \Carbon\Carbon::parse($property->created_at)->format('F j, Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS to Sync Clicked Image to Modal Carousel Index -->
<script>
    document.querySelectorAll('.preview-image').forEach((img, index) => {
        img.addEventListener('click', function () {
            const modalCarousel = document.querySelector('#modalCarousel');
            const bsCarousel = bootstrap.Carousel.getInstance(modalCarousel) || new bootstrap.Carousel(modalCarousel);
            bsCarousel.to(index);
        });
    });
</script>
@endsection
