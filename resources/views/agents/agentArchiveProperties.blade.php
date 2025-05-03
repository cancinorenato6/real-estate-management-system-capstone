@extends('components.agentLayout')

@section('title', 'Archived Properties')

@section('Content')
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif

<div class="container mt-4">
    <h2>Archived Properties</h2>

    <div class="row">
        @forelse($archivedProperties as $property)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Agent Info inside the card -->
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
                        
                        <form action="{{ route('property.restore', $property->id) }}" method="POST" class="d-inline restore-form">
                            @csrf
                            <button type="button" class="btn btn-outline-success btn-sm restore-btn">Restore</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No archived properties found.</p>
        @endforelse
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.restore-form');

            Swal.fire({
                title: 'Restore this property?',
                text: "The property will be restored and visible again.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection



