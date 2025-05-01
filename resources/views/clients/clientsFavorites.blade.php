@extends('components.clientLayout')

@section('title', 'Favorites')

@section('Content')
    <div>
        <h1>My Favorite Properties</h1>
        @forelse($client->favorites as $property)
            <div>
                <h3>{{ $property->title }}</h3>
                <p>{{ $property->description }}</p>
                <p>Price: ₱{{ number_format($property->price, 2) }}</p>
            </div>
        @empty
            <p>You have no favorites yet.</p>
        @endforelse
    </div>
@endsection
