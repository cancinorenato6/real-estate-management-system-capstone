    @extends('components.adminLayout')

    @section('title', 'Agents')

    @section('Content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <div class="container p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Agents</h1>
            <div>
                {{-- <a href="{{ route('agents.create') }}" class="btn btn-success"> --}}
                    <a href="{{route('agentsCreate')}}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Create
                </a>
                <button class="btn btn-primary" onclick="location.reload();">
                    <i class="fas fa-sync"></i> Reload
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agents as $agent)
                        <tr>
                            <td>
                                <img src="{{ $agent->profile_pic ? asset('storage/' . $agent->profile_pic) : asset('img/agentDefaultProfile.jpg') }}" class="rounded-circle" alt="Profile" width="40" height="40">
                                <span class="ml-2">{{ $agent->name }}</span>
                            </td>
                            <td>{{ $agent->email }}</td>
                            <td>
                                @if ($agent->status == '1')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deactivateAgent('{{ route('deactivateAgent', $agent->id) }}', '{{ $agent->status == 1 ? 'deactivate' : 'activate' }}')">
                                            {{ $agent->status == 1 ? 'Deactivate' : 'Activate' }}
                                        </a>
                                        
                                        <script>
                                            function deactivateAgent(url, action) {
                                                Swal.fire({
                                                    title: `Are you sure you want to ${action} this agent?`,
                                                    text: "This action cannot be undone.",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Yes, continue',
                                                    cancelButtonText: 'No, cancel',
                                                    reverseButtons: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // If confirmed, redirect to the given URL
                                                        window.location.href = url;
                                                    }
                                                });
                                            }
                                        </script>
                                        
                                         
                                        <a class="dropdown-item" href="#">Edit Password</a>
                                        <a class="dropdown-item" href="{{ route('viewAgent', $agent->id) }}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No agents found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection
