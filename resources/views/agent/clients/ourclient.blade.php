@extends('agent.layouts.app')
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

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="col-12">
                            <div class="card">
                                <div id="cardHeader"
                                    class="card-header bg-primary d-flex justify-content-between align-items-center position-sticky top-0  shadow"
                                    style="z-index: 0;">

                                    <h4 class="card-title">My Clients</h4>
                                    <div class="d-flex justify-content-end">

                                        <form action="{{ route('agent.ourClients') }}" method="GET"
                                            class="d-flex justify-content-end">
                                            <input type="text" name="search" class="form-control me-2"
                                                placeholder="Search ..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-light me-2">Search</button>
                                            <a href="{{ route('agent.ourClients') }}"
                                                class="btn btn-danger pt-2 me-2">Reset</a>
                                        </form>

                                    </div>
                                </div>
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">

                                    <div class="table-responsive">

                                        <table id="datatable-row-callback"
                                            class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                            style="width: 100%;">
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
                                                @foreach ($myclients as $index => $client)
                                                    <tr>
                                                        <td>
                                                            {{ $index + 1 + ($myclients->currentPage() - 1) * $myclients->perPage() }}

                                                        </td>
                                                        <td>
                                                            <strong>{{ $client->name }}</strong>
                                                        </td>
                                                        <td>{{ $client->phone }}</td>

                                                        <td>{{ $client->email }}</td>

                                                        <td>
                                                            @if ($client->status == 1)
                                                                <span class="badge bg-success">Active</span>
                                                            @else
                                                                <span class="badge bg-danger">Pending</span>
                                                            @endif
                                                        </td>

                                                        <td>{{ $client->created_at->format('d-M-Y') }}</td>


                                                        <td>
                                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#editClientModal{{ $client->id }}"> <i
                                                                    class="fas fa-pencil-alt"></i></button>

                                                            <button type="button" class="btn btn-danger delete-btn"
                                                                data-id="{{ $client->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Client Modal -->
                                                    <div class="modal fade" id="editClientModal{{ $client->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editClientModalLabel{{ $client->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editClientModalLabel{{ $client->id }}">Edit
                                                                        Client</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('agent.clients.update', $client->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="name"
                                                                                    class="form-label">Name</label>
                                                                                <input type="text" name="name"
                                                                                    class="form-control"
                                                                                    value="{{ $client->name }}">
                                                                                @error('name')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="email"
                                                                                    class="form-label">Email</label>
                                                                                <input type="email" name="email"
                                                                                    class="form-control"
                                                                                    value="{{ $client->email }}">
                                                                                @error('email')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="phone"
                                                                                    class="form-label">Phone</label>
                                                                                <input type="text" name="phone"
                                                                                    class="form-control"
                                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                                                    maxlength="10"
                                                                                    value="{{ $client->phone }}">
                                                                                @error('phone')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>


                                                                            <div class="col-md-6">
                                                                                <label for="exampleFormControlInput1"
                                                                                    class="form-label">Status<span
                                                                                        class="text-danger">*</span></label>
                                                                                <select name="status" class="form-control">
                                                                                    <option value="1"
                                                                                        {{ old('status', $client->status) == '1' ? 'selected' : '' }}>
                                                                                        Active</option>
                                                                                    <option value="0"
                                                                                        {{ old('status', $client->status) == '0' ? 'selected' : '' }}>
                                                                                        Pending
                                                                                    </option>
                                                                                </select>
                                                                                @error('status')
                                                                                    <span class="text-danger" role="alert">
                                                                                        <strong>{{ ucwords($message) }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>


                                                                            {{-- Avatar --}}
                                                                            <div class="col-md-12">
                                                                                <div class="form-group ">
                                                                                    <label for="signinSrEmail">Select The
                                                                                        Profile Image (300x300) </label>

                                                                                    <div class="input-group"
                                                                                        data-toggle="aizuploader"
                                                                                        data-type="image"
                                                                                        data-multiple="false">
                                                                                        <div class="input-group-prepend">
                                                                                            <div
                                                                                                class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                                Browse
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="form-control file-amount">
                                                                                            Choose File</div>
                                                                                        <input type="hidden"
                                                                                            name="avatar"
                                                                                            value="{{ old('avatar', $client->avatar) }}"
                                                                                            class="selected-files">
                                                                                    </div>
                                                                                    <div class="file-preview box sm">

                                                                                    </div>

                                                                                    @error('avatar')
                                                                                        <span class="text-danger"
                                                                                            role="alert">
                                                                                            <strong>{{ ucwords($message) }}</strong>
                                                                                        </span>
                                                                                    @enderror

                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-12 mb-3">
                                                                                <label for="message">Address</label>
                                                                                <textarea name="address" class="form-control" rows="2">{{ $client->address }}</textarea>
                                                                                @error('address')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>


                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-dark"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Save
                                                                                    Changes</button>
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Edit Client Modal -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-4">
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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const pageId = this.getAttribute('data-id');

                    // Confirmation dialog
                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete the Page. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    });

                    if (result.isConfirmed) {
                        try {
                            // Make the delete request
                            const response = await fetch(
                                `/agent/clients/delete/${pageId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).getAttribute('content'),
                                    },
                                });

                            // Check if the response is okay
                            if (!response.ok) {
                                const errorData = await response.json();
                                throw new Error(errorData.error || 'Failed to delete the Page');
                            }

                            // Success alert
                            await Swal.fire('Deleted!', 'Page has been deleted.', 'success');
                            location.reload();
                        } catch (error) {
                            // Show detailed error message
                            Swal.fire('Oops...', error.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
