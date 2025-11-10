@extends('agent.layouts.app')
@section('content')
    @push('styles')
        <style>
            @media (max-width: 768px) {
                .card-body {
                    max-height: none !important;
                    height: 100vh !important;
                }
            }
        </style>
        <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
    @endpush

    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- Alerts --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-white">My Clients</h4>

                                    <form action="{{ route('agent.ourClients') }}" method="GET" class="d-flex gap-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search..."
                                            value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-light">Search</button>
                                        <a href="{{ route('agent.ourClients') }}" class="btn btn-danger">Reset</a>
                                    </form>
                                </div>

                                <div class="card-body" style="max-height: 450px; overflow-y:auto;">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Operation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($myclients as $client)
                                                    <tr>
                                                        <td>{{ $loop->iteration + ($myclients->currentPage() - 1) * $myclients->perPage() }}
                                                        </td>
                                                        <td><strong>{{ $client->name }}</strong></td>
                                                        <td>{{ $client->phone }}</td>
                                                        <td>{{ $client->email }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $client->status ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $client->status ? 'Active' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $client->created_at->format('d-M-Y') }}</td>
                                                        <td>
                                                            <button class="btn btn-primary editBtn"
                                                                data-id="{{ $client->id }}"
                                                                data-name="{{ $client->name }}"
                                                                data-email="{{ $client->email }}"
                                                                data-phone="{{ $client->phone }}"
                                                                data-avatar="{{ $client->avatar }}"
                                                                data-address="{{ $client->address }}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>

                                                            {{-- <button class="btn btn-danger delete-btn"
                                                                data-id="{{ $client->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $myclients->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Single Reusable Edit Modal --}}
    <div class="modal fade" id="editClientModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editClientForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5>Edit Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="edit_phone" maxlength="10" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" id="edit_address" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        // ✅ Open Edit Modal
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                $('#edit_id').val(btn.dataset.id);
                $('#edit_name').val(btn.dataset.name);
                $('#edit_email').val(btn.dataset.email);
                $('#edit_phone').val(btn.dataset.phone);
                $('#edit_address').val(btn.dataset.address);
                $('#editClientForm').attr('action', `/agent/clients/update/${btn.dataset.id}`);
                $('#editClientModal').modal('show');
            });
        });

        // ✅ Delete Client
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: "Confirm Delete?",
                    text: "This cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Delete"
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/agent/clients/delete/${btn.dataset.id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        }).then(() => location.reload());
                    }
                });
            });
        });
    </script>
@endpush
