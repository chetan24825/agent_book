@extends('admin.layouts.app')
@section('content')
    @push('styles')
        <style>
            @media (max-width: 768px) {
                .card-body {
                    height: 100vh !important;
                    /* Full height on mobile */
                    max-height: none !important;
                    /* Remove max-height */
                }
            }
        </style>
    @endpush
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!--<div class="row">-->
                    <!--    <div class="col-12">-->
                    <!--        <div class="page-title-box d-flex align-items-center justify-content-between">-->
                    <!--            <h4 class="mb-sm-0">Home</h4>-->
                    <!--            <div class="page-title-right">-->
                    <!--                <ol class="breadcrumb m-0">-->
                    <!--                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>-->
                    <!--                    <li class="breadcrumb-item active">Agents</li>-->
                    <!--                </ol>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center position-sticky top-0  shadow"
                                    style="z-index: 0;">

                                    <h4 class="card-title">Agents</h4>
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('admin.agents') }}" method="GET"
                                            class="d-flex justify-content-end">
                                            <input type="text" name="search" class="form-control me-2"
                                                placeholder="Search ..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-light me-2">Search</button>
                                            <a href="{{ route('admin.agents') }}" class="btn btn-danger pt-2 me-2">Reset</a>
                                        </form>
                                        <a href="{{ route('admin.download.agents') }}" class="btn btn-dark pt-2">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                    <div class="table-responsive">
                                        <table id="datatable-row-callback"
                                            class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Agent Code</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Status</th>
                                                    <th>Verification</th>

                                                    <th>Created</th>
                                                    <th>Operation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($agents as $index => $agent)
                                                    <tr>
                                                        <td>{{ ($agents->currentPage() - 1) * $agents->perPage() + $index + 1 }}
                                                        </td>
                                                        <td>{{ $agent->name }}</td>
                                                        <td>
                                                            <span class="badge bg-success">{{ $agent->agent_code }}</span>
                                                        </td>


                                                        <td>{{ $agent->email }}</td>
                                                        <td>{{ $agent->phone }}</td>
                                                        <td>
                                                            @if ($agent->status == 1)
                                                                <span class="badge bg-success">Active</span>
                                                            @else
                                                                <span class="badge bg-danger">In-Active</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($agent->admin_verification_status == 1)
                                                                <span class="badge bg-success">Verified</span>
                                                            @else
                                                                <span class="badge bg-warning">Not-Verified</span>
                                                            @endif
                                                        </td>

                                                        <td>{{ $agent->created_at->format('d-M-Y') }}</td>
                                                        <td>

                                                            <!-- <button type="button" class="btn btn-danger  delete-btn"
                                                                                        data-id="{{ $agent->id }}">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </button> -->

                                                            <a href="{{ route('admin.agent.show', $agent->id) }}"
                                                                target="blank" class="btn btn-success"><i
                                                                    class="fas fa-pencil-alt"></i></a>


                                                            @if ($agent->status == 1)
                                                                <a href="{{ route('admin.agent.view', $agent->id) }}"
                                                                    target="blank" class="btn btn-info"><i
                                                                        class="fas fa-eye"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $agents->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const agentId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete the agent. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('admin/agent-delete') }}/${agentId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content')
                                }
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText);
                                }
                                return response.json();
                            }).then(data => {
                                Swal.fire('Deleted!', 'Agent has been deleted.',
                                    'success').then(() => {
                                    location.reload();
                                });
                            }).catch(error => {
                                Swal.fire('Oops...', 'Something went wrong!',
                                    'error');
                            });
                        }
                    });
                });
            });
        });
    </script>
@endpush
