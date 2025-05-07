{{-- @extends('components.clientLayout', ['total_unread' => $total_unread])

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
    <div class="mb-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listPropertyModal">
            <i class="bi bi-plus"></i> List Property with Agents
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="listPropertyModal" tabindex="-1" aria-labelledby="listPropertyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="listPropertyModalLabel">List Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="listPropertyForm" method="POST" action="{{ route('client.broadcastMessage') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Describe your property or request..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send to All Agents</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm hover-shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="bi bi-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-envelope-slash mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0 text-muted" style="font-size: 1.2rem;">No conversations found. Try contacting an agent from a property listing.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        <li class="list-group-item">
                            <a href="{{ route('client.conversation', ['property_id' => $conversation['property'] ? $conversation['property']->id : 0, 'agent_id' => $conversation['agent']->id]) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; height: 60px;" class="me-3">
                                        @if($conversation['property'] && !empty($conversation['property']->images) && is_array($conversation['property']->images))
                                            <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                <i class="bi bi-house" style="font-size: 1.5rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $conversation['property'] ? $conversation['property']->title : 'General Inquiry' }}</h6>
                                        <p class="mb-0 text-muted">Agent: {{ $conversation['agent']->name }}</p>
                                        <small class="text-muted">{{ $conversation['last_message'] ? \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() : '' }}</small>
                                    </div>
                                    @if($conversation['unread_count'] > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $conversation['unread_count'] }}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection --}}

@extends('components.clientLayout', ['total_unread' => $total_unread])

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
        <div class="mb-4">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listPropertyModal">
                <i class="bi bi-plus"></i> List Your Property
            </button>
            </div>
    <div class="card shadow-sm hover-shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="bi bi-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-envelope-slash mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0 text-muted" style="font-size: 1.2rem;">No conversations found. Try contacting an agent from a property listing.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        <li class="list-group-item">
                            <a href="{{ route('client.conversation', ['property_id' => $conversation['property']->id, 'agent_id' => $conversation['agent']->id]) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; height: 60px;" class="me-3">
                                        @if(!empty($conversation['property']->images) && is_array($conversation['property']->images))
                                            <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                <i class="bi bi-house" style="font-size: 1.5rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $conversation['property']->title }}</h6>
                                        <p class="mb-0 text-muted">Agent: {{ $conversation['agent']->name }}</p>
                                        <small class="text-muted">{{ $conversation['last_message'] ? \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() : '' }}</small>
                                    </div>
                                    @if($conversation['unread_count'] > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $conversation['unread_count'] }}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="listPropertyModal" tabindex="-1" aria-labelledby="listPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listPropertyModalLabel">List Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="listPropertyForm" method="POST" action="#">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Describe your property or request..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send to All Agents</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection