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
@endsection --}}
{{-- @extends('components.agentLayout', ['total_unread' => $total_unread])

@section('title', 'Messages')

@section('Content')
<div class="container py-4">
    <h2>My Messages @if($total_unread > 0)<span class="badge bg-danger">{{ $total_unread }}</span>@endif</h2>
    <div class="card shadow-sm hover-shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Conversations</h4>
        </div>
        <div class="card-body p-0">
            @if($conversations->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-envelope-slash mb-2" style="font-size: 2rem; color: #6c757d;"></i>
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
                                        <p class="mb-0 text-muted">Client: {{ $conversation['client']->first_name }} {{ $conversation['client']->last_name }}</p>

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
{{-- @extends('components.agentLayout', ['total_unread' => $total_unread])

@section('title', 'My Messages')

@section('Content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-comments me-2"></i>My Messages</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    @if($conversations->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comments mb-3" style="font-size: 3rem;"></i>
                            <h5>No conversations yet</h5>
                            <p class="text-muted">You'll see messages from clients here</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('agent.conversation', ['property_id' => $conversation['property']->id, 'client_id' => $conversation['client']->id]) }}" 
                                   class="list-group-item list-group-item-action p-3 hover-shadow">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if($conversation['property']->id == 0)
                                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-comment-alt text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                            @else
                                                @if(!empty($conversation['property']->images) && count($conversation['property']->images) > 0)
                                                    <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" alt="{{ $conversation['property']->title }}" 
                                                         class="img-thumbnail rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-building text-secondary" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    @if($conversation['property']->id == 0)
                                                        General Inquiry
                                                    @else
                                                        {{ $conversation['property']->title }}
                                                    @endif
                                                    @if($conversation['unread_count'] > 0)
                                                        <span class="badge bg-primary rounded-pill ms-2">{{ $conversation['unread_count'] }}</span>
                                                    @endif
                                                </h6>
                                                <p class="mb-1 text-muted">Client: {{ $conversation['client']->first_name }} {{ $conversation['client']->last_name }}</p>
                                                <small class="text-truncate d-inline-block" style="max-width: 300px;">
                                                    {{ $conversation['last_message']->message }}
                                                </small>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('components.agentLayout', ['total_unread' => $total_unread])

@section('title', 'My Messages')

@section('Content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-comments me-2"></i>My Messages</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    @if($conversations->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comments mb-3" style="font-size: 3rem;"></i>
                            <h5>No conversations yet</h5>
                            <p class="text-muted">You'll see messages from clients here</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('agent.conversation', ['property_id' => $conversation['property']->id, 'client_id' => $conversation['client']->id]) }}" 
                                   class="list-group-item list-group-item-action p-3 hover-shadow">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if(is_null($conversation['property']->id))
                                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-comment-alt text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                            @else
                                                @if(!empty($conversation['property']->images) && count($conversation['property']->images) > 0)
                                                    <img src="{{ asset('storage/' . $conversation['property']->images[0]) }}" alt="{{ $conversation['property']->title }}" 
                                                         class="img-thumbnail rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-building text-secondary" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                            @endif
                                            <div>
                                                <h6 class="mb-1">
                                                    @if(is_null($conversation['property']->id))
                                                        General Inquiry
                                                    @else
                                                        {{ $conversation['property']->title }}
                                                    @endif
                                                    @if($conversation['unread_count'] > 0)
                                                        <span class="badge bg-primary rounded-pill ms-2">{{ $conversation['unread_count'] }}</span>
                                                    @endif
                                                </h6>
                                                <p class="mb-1 text-muted">Client: {{ $conversation['client']->first_name }} {{ $conversation['client']->last_name }}</p>
                                                <small class="text-truncate d-inline-block" style="max-width: 300px;">
                                                    {{ $conversation['last_message']->message }}
                                                </small>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($conversation['last_message']->created_at)->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection