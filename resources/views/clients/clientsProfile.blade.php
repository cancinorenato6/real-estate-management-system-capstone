{{-- @extends('components.clientLayout')

@section('title', 'Client Profile')

@section('Content')
<div>
    @auth('client')
    <h1>Welcome, {{ Auth::guard('client')->user()->first_name }}!</h1>
@endauth
</div>
@if(Auth::guard('client')->check())
    <p>Client is logged in.</p>
@else
    <p>No client is logged in.</p>
@endif
<h1>Hi this is Clients</h1>

<a href="#" 
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

 --}}
 @extends('components.clientLayout')

 @section('title', 'Profile')
 
 @section('Content')
     <div>
         @auth('client')
             <h1 class="h3 mb-2">Welcome, {{ Auth::guard('client')->user()->first_name,}} {{ Auth::guard('client')->user()->last_name }}</h1>
             <p class="text-success">Client is logged in.</p>
         @else
             <p class="text-danger">No client is logged in.</p>
         @endauth
 
         <h2 class="mt-4">Hi, this is Clients</h2>
     </div>
 @endsection
 
 