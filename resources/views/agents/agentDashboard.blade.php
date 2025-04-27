@extends('components.agentLayout')

@section('title', 'Dashboard')

@section('Content')
    <div>
        @if(Auth::guard('agent')->check())
            <h1 class="h3 mb-2">Welcome, {{ Auth::guard('agent')->user()->first_name }}!</h1>
            <p class="text-success">Agent is logged in.</p>
        @else
            <p class="text-danger">No agent is logged in.</p>
        @endif

        <h2 class="mt-4">Hi, this is Agent</h2>
    </div>
@endsection

