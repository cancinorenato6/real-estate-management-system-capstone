{{-- @extends('components.agentLayout')

@section('title', 'Edit Property')

@section('Content')
<div class="container mt-5">
    <a href="{{ route('agentProperties') }}" class="btn btn-secondary mb-3">← Go Back</a>
    <h2>Edit Property</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('updateProperty', ['id' => $property->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Property Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $property->title }}" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $property->price }}" required>
        </div>

        <!-- Offer Type -->
        <div class="mb-3">
            <label for="offer_type" class="form-label">Offer Type</label>
            <select class="form-select" id="offer_type" name="offer_type" required>
                <option value="sell" {{ $property->offer_type === 'sell' ? 'selected' : '' }}>Sell</option>
                <option value="rent" {{ $property->offer_type === 'rent' ? 'selected' : '' }}>Rent</option>
            </select>
        </div>

        <!-- Property Type -->
        <div class="mb-3">
            <label for="property_type" class="form-label">Property Type</label>
            <select name="property_type" id="property_type" class="form-select" required>
                <option value="condominium" {{ $property->property_type === 'condominium' ? 'selected' : '' }}>Condominium</option>
                <option value="commercial_space" {{ $property->property_type === 'commercial_space' ? 'selected' : '' }}>Commercial Space</option>
                <option value="apartment" {{ $property->property_type === 'apartment' ? 'selected' : '' }}>Apartment</option>
                <option value="house" {{ $property->property_type === 'house' ? 'selected' : '' }}>House</option>
                <option value="land" {{ $property->property_type === 'land' ? 'selected' : '' }}>Land</option>
            </select>
        </div>

        <!-- Location -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay" value="{{ $property->barangay }}" required>
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $property->city }}" required>
            </div>
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <input type="text" class="form-control" id="province" name="province" value="{{ $property->province }}" required>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $property->description }}</textarea>
        </div>

        <!-- Upload New Images -->
        <div class="mb-4">
            <label for="images" class="form-label">Upload New Property Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
            <small class="text-muted">You may upload additional JPG, JPEG, or PNG images (Max 2MB each).</small>
        </div>

        <!-- Show existing images -->
        @if(is_array($property->images) && count($property->images) > 0)
        <div class="mb-4">
            <label class="form-label">Current Images:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($property->images as $image)
                    <div style="width: 120px;">
                        <img src="{{ asset('storage/' . $image) }}" alt="Property Image" class="img-thumbnail" style="width: 100%; height: auto;">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Submit -->
        <button type="submit" class="btn btn-success">Update Property</button>
        <a href="{{ route('agentProperties') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection --}}
@extends('components.agentLayout')

@section('title', 'Edit Property')

@section('Content')
<div class="container mt-5">
    <a href="{{ route('agentProperties') }}" class="btn btn-secondary mb-3">← Go Back</a>
    <h2>Edit Property</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('updateProperty', ['id' => $property->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Offer Type & Property Type -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="offer_type" class="form-label">Offer Type</label>
                <select class="form-select" id="offer_type" name="offer_type" required>
                    <option value="sell" {{ $property->offer_type === 'sell' ? 'selected' : '' }}>Sell</option>
                    <option value="rent" {{ $property->offer_type === 'rent' ? 'selected' : '' }}>Rent</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="property_type" class="form-label">Property Type</label>
                <select name="property_type" id="property_type" class="form-select" required>
                    <option value="condominium" {{ $property->property_type === 'condominium' ? 'selected' : '' }}>Condominium</option>
                    <option value="commercial_space" {{ $property->property_type === 'commercial_space' ? 'selected' : '' }}>Commercial Space</option>
                    <option value="apartment" {{ $property->property_type === 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="house" {{ $property->property_type === 'house' ? 'selected' : '' }}>House</option>
                    <option value="land" {{ $property->property_type === 'land' ? 'selected' : '' }}>Land</option>
                </select>
            </div>
        </div>

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Property Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $property->title }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $property->description }}</textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $property->price }}" step="0.01" required>
        </div>

        <!-- Location -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <input type="text" class="form-control" id="province" name="province" value="{{ $property->province }}" required>
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $property->city }}" required>
            </div>
            <div class="col-md-4">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay" value="{{ $property->barangay }}" required>
            </div>
        </div>
        
        <!-- Map Coordinates -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="number" class="form-control" id="latitude" name="latitude" value="{{ $property->latitude }}" step="0.00000001" placeholder="e.g., 14.5995">
                <small class="text-muted">Optional: Decimal format (up to 8 decimal places)</small>
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="number" class="form-control" id="longitude" name="longitude" value="{{ $property->longitude }}" step="0.00000001" placeholder="e.g., 120.9842">
                <small class="text-muted">Optional: Decimal format (up to 8 decimal places)</small>
            </div>
        </div>

        <!-- Upload New Images -->
        <div class="mb-4">
            <label for="images" class="form-label">Upload New Property Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
            <small class="text-muted">You may upload additional JPG, JPEG, or PNG images (Max 2MB each).</small>
        </div>

        <!-- Show existing images -->
        @if(is_array($property->images) && count($property->images) > 0)
        <div class="mb-4">
            <label class="form-label">Current Images:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($property->images as $image)
                    <div style="width: 120px;">
                        <img src="{{ asset('storage/' . $image) }}" alt="Property Image" class="img-thumbnail" style="width: 100%; height: auto;">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Submit -->
        <button type="submit" class="btn btn-success">Update Property</button>
        <a href="{{ route('agentProperties') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection