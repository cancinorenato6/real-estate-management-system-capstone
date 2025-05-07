@extends('components.agentLayout')

@section('title', 'Agent Account')
 
@section('Content')
    <div class="container py-4">
        @auth('agent')
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if($agent->profile_pic)
                                    <img src="{{ asset('storage/' . $agent->profile_pic) }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/agentDefaultProfile.jpg') }}" 
                                         alt="Default Profile Picture" 
                                         class="rounded-circle img-fluid" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>
                            <h5 class="mb-1">{{ $agent->name }}</h5>
                            <p class="text-muted mb-3">PRC ID: {{ $agent->prc_id }}</p>
                            <p class="text-muted mb-1">Account Type: Agent</p>
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
                                    <p class="text-muted mb-0">{{ $agent->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Contact</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->contactno }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Username</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->username }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Age</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->age }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Birthday</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->birthday }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">Upload Profile Picture</div>
                        <div class="card-body">
                            <form action="{{ route('updateAgentProfilePic') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="profile_pic" class="form-label">Choose a new profile picture</label>
                                    <input class="form-control" type="file" id="profile_pic" name="profile_pic">
                                </div>
                                <button type="submit" class="btn btn-success">Upload Picture</button>
                            </form>
                            {{-- <form action="{{ route('updateAgentProfilePic') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="profile_pic" class="form-label">Choose a new profile picture</label>
                                    <input class="form-control" type="file" id="profile_pic" name="profile_pic" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <div id="imagePreview" class="text-center d-none">
                                        <img id="preview" src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload Picture</button>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                <p>No agent is logged in. Please <a href="{{ route('agentLogin') }}">login</a> to view your profile.</p>
            </div>
        @endauth
    </div>
@endsection

{{-- @extends('components.agentLayout')

@section('title', 'Agent Account')
 
@section('Content')
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @auth('agent')
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow">
                        <div class="card-body text-center">
                            <div class="mb-3 position-relative">
                                @if($agent->profile_pic)
                                    <img src="{{ asset('storage/profile_pics/' . $agent->profile_pic) }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle img-fluid border" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('img/agentDefaultProfile.jpg') }}" 
                                         alt="Default Profile Picture" 
                                         class="rounded-circle img-fluid border" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                                <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                                        data-bs-toggle="modal" data-bs-target="#updateProfilePicModal" 
                                        style="margin-right: 30px;">
                                    <i class="bi bi-camera-fill"></i>
                                </button>
                            </div>
                            <h5 class="mb-1">{{ $agent->name }}</h5>
                            <p class="text-muted mb-3">PRC ID: {{ $agent->prc_id }}</p>
                            <p class="text-muted mb-1">Account Type: Agent</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-person-lines-fill me-2"></i>Account Information
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Contact</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->contactno }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Username</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->username }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $agent->address }}</p>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                <p>No agent is logged in. Please <a href="{{ route('agentLogin') }}">login</a> to view your profile.</p>
            </div>
        @endauth
    </div>

    <!-- Profile Picture Update Modal -->
    <div class="modal fade" id="updateProfilePicModal" tabindex="-1" aria-labelledby="updateProfilePicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfilePicModalLabel">Update Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateAgentProfilePic') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Choose a new profile picture</label>
                            <input class="form-control" type="file" id="profile_pic" name="profile_pic" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <div id="imagePreview" class="text-center d-none">
                                <img id="preview" src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Upload Picture</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $agent->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $agent->email }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contactno" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactno" name="contactno" value="{{ $agent->contactno }}">
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ $agent->username }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ $agent->address }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const profilePicInput = document.getElementById('profile_pic');
            const imagePreview = document.getElementById('imagePreview');
            const preview = document.getElementById('preview');
            
            profilePicInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection --}}