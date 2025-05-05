{{-- @extends('components.agentLayout')

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-envelope-open-text mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0 text-muted" style="font-size: 1.2rem;">No conversations found. Check for client messages from property listings.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        <li class="list-group-item">
                            <a href="{{ route('agent.conversation', ['property_id' => $conversation['property'] ? $conversation['property']->id : 0, 'client_id' => $conversation['client']->id]) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; height: 60px;" class="me-3">
                                        @if($conversation['property'] && !empty($conversation['property']->images) && is_array($conversation['property']->images))
                                            <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                <i class="fas fa-building" style="font-size: 1.5rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $conversation['property'] ? $conversation['property']->title : 'General Inquiry' }}</h6>
                                        <p class="mb-0 text-muted">Client: {{ $conversation['client']->name }}</p>
                                        <small class="text-muted">{{ $conversation['last_message'] ? \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() : '' }}</small>
                                    </div>
                                    @if($conversation['has_unread'])
                                        <span class="badge bg-danger rounded-pill">New</span>
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

{{-- @extends('components.agentLayout')

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-envelope-open-text mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0 text-muted" style="font-size: 1.2rem;">
                        No conversations found. Check for client messages from property listings.
                    </p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        @php
                            $isClaimed = $conversation['last_message'] && $conversation['last_message']->claimed_by_agent_id;
                            $claimedByCurrentAgent = $isClaimed && $conversation['last_message']->claimed_by_agent_id == Auth::guard('agent')->id();
                            $isUnclaimed = !$isClaimed;
                        @endphp

                        @if($isUnclaimed || $claimedByCurrentAgent)
                            <li class="list-group-item">
                                <a href="{{ route('agent.conversation', [
                                    'property_id' => $conversation['property'] ? $conversation['property']->id : 0,
                                    'client_id' => $conversation['client']->id
                                ]) }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 60px; height: 60px;" class="me-3">
                                            @if($conversation['property'] && !empty($conversation['property']->images) && is_array($conversation['property']->images))
                                                <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                    <i class="fas fa-building" style="font-size: 1.5rem; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $conversation['property'] ? $conversation['property']->title : 'General Inquiry' }}</h6>
                                            <p class="mb-0 text-muted">Client: {{ $conversation['client']->name }}</p>
                                            <small class="text-muted">
                                                {{ $conversation['last_message'] ? \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() : '' }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                Claimed: 
                                                @if ($isUnclaimed)
                                                    <span class="text-warning">Unclaimed</span>
                                                @elseif ($claimedByCurrentAgent)
                                                    <span class="text-success">You</span>
                                                @else
                                                    <span class="text-muted">Another Agent</span>
                                                @endif
                                            </small>
                                        </div>
                                        @if($conversation['has_unread'])
                                            <span class="badge bg-danger rounded-pill">New</span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection --}}


@extends('components.agentLayout')

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-envelope-open-text mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0 text-muted" style="font-size: 1.2rem;">No conversations found. Check for client messages from property listings.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($conversations as $conversation)
                        <li class="list-group-item">
                            <a href="{{ route('agent.conversation', ['property_id' => $conversation['property']->id, 'client_id' => $conversation['client']->id]) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; height: 60px;" class="me-3">
                                        @if(!empty($conversation['property']->images) && is_array($conversation['property']->images))
                                            <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" class="rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">
                                                <i class="fas fa-building" style="font-size: 1.5rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $conversation['property']->title }}</h6>
                                        <p class="mb-0 text-muted">Client: {{ $conversation['client']->name }}</p>
                                        <small class="text-muted">{{ $conversation['last_message'] ? \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() : '' }}</small>
                                    </div>
                                    @if($conversation['has_unread'])
                                        <span class="badge bg-danger rounded-pill">New</span>
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
@endsection