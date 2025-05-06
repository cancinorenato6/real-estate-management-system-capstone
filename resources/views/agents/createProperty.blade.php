{{-- @extends('components.agentLayout')

@section('title', 'Add New Property')

@section('Content')
<div class="container mt-4">
    <a href="{{ route('agentProperties') }}" class="btn btn-secondary mb-3">← Go Back</a>
    <h2 class="mb-4">Add New Property</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('storeProperty') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="offer_type" class="form-label">Offer Type</label>
                <select name="offer_type" id="offer_type" class="form-select" required>
                    <option value="">Select offer type</option>
                    <option value="sell">Sell</option>
                    <option value="rent">Rent</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="property_type" class="form-label">Property Type</label>
                <select name="property_type" id="property_type" class="form-select" required>
                    <option value="">Select property type</option>
                    <option value="condominium">Condominium</option>
                    <option value="commercial_space">Commercial Space</option>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                    <option value="land">Land</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Property Title</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g., Adella Duplex Corner Lot">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Property Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required placeholder="Enter detailed description..."></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" name="price" id="price" class="form-control" required placeholder="e.g., 8367650">
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" required placeholder="e.g., La Union">
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City/Municipality</label>
                <input type="text" name="city" id="city" class="form-control" required placeholder="e.g., San Fernando">
            </div>
            <div class="col-md-4">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" name="barangay" id="barangay" class="form-control" required placeholder="e.g., Sevilla">
            </div>
        </div>

        <div class="mb-4">
            <label for="images" class="form-label">Upload Property Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" required>
            <small class="text-muted">Each image must be JPG, JPEG, or PNG, max 2MB each.</small>
        </div>

        <button type="submit" class="btn btn-success">Submit Property</button>
    </form>
</div>
@endsection --}}
@extends('components.agentLayout')

@section('title', 'Add New Property')

@section('Content')
<div class="container mt-4">
    <a href="{{ route('agentProperties') }}" class="btn btn-secondary mb-3">← Go Back</a>
    <h2 class="mb-4">Add New Property</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('storeProperty') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="offer_type" class="form-label">Offer Type</label>
                <select name="offer_type" id="offer_type" class="form-select" required>
                    <option value="">Select offer type</option>
                    <option value="sell">Sell</option>
                    <option value="rent">Rent</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="property_type" class="form-label">Property Type</label>
                <select name="property_type" id="property_type" class="form-select" required>
                    <option value="">Select property type</option>
                    <option value="condominium">Condominium</option>
                    <option value="commercial_space">Commercial Space</option>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                    <option value="land">Land</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Property Title</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g., Adella Duplex Corner Lot">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Property Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required placeholder="Enter detailed description..."></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₱)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required placeholder="e.g., 8367650">
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" required placeholder="e.g., La Union">
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City/Municipality</label>
                <input type="text" name="city" id="city" class="form-control" required placeholder="e.g., San Fernando">
            </div>
            <div class="col-md-4">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" name="barangay" id="barangay" class="form-control" required placeholder="e.g., Sevilla">
            </div>
        </div>
        
        <!-- Map Coordinates -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="number" name="latitude" id="latitude" class="form-control" step="0.00000001" placeholder="e.g., 14.5995">
                <small class="text-muted">Optional: Decimal format (up to 8 decimal places)</small>
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="number" name="longitude" id="longitude" class="form-control" step="0.00000001" placeholder="e.g., 120.9842">
                <small class="text-muted">Optional: Decimal format (up to 8 decimal places)</small>
            </div>
        </div>

        <div class="mb-4">
            <label for="images" class="form-label">Upload Property Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" required>
            <small class="text-muted">Each image must be JPG, JPEG, or PNG, max 2MB each.</small>
        </div>

        <button type="submit" class="btn btn-success">Submit Property</button>
    </form>
</div>
@endsection