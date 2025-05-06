{{-- 
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
 
  --}}
  @extends('components.clientLayout')

@section('title', 'Profile')
 
@section('Content')
    <div class="container py-4">
        @auth('client')
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if(Auth::guard('client')->user()->profile_pic)
                                    <img src="{{ asset('storage/profile_pics/' . Auth::guard('client')->user()->profile_pic) }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/clientDefaultProfile.jpg') }}" 
                                         alt="Default Profile Picture" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>
                            <h5 class="mb-1">{{ Auth::guard('client')->user()->first_name }} {{ Auth::guard('client')->user()->last_name }}</h5>
                            <p class="text-muted mb-3">Account ID: {{ Auth::guard('client')->user()->id }}</p>
                            <p class="text-muted mb-1">Account Type: Client</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">Account Information</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ Auth::guard('client')->user()->first_name }} {{ Auth::guard('client')->user()->last_name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ Auth::guard('client')->user()->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Contact</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ Auth::guard('client')->user()->contact_number }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Username</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ Auth::guard('client')->user()->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">Upload Profile Picture</div>
                        <div class="card-body">
                            <form action="{{ route('updateProfilePic') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="profile_pic" class="form-label">Choose a new profile picture</label>
                                    <input class="form-control" type="file" id="profile_pic" name="profile_pic">
                                </div>
                                <button type="submit" class="btn btn-success">Upload Picture</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                <p>No client is logged in. Please <a href="{{ route('clientLogin') }}">login</a> to view your profile.</p>
            </div>
        @endauth
    </div>
@endsection