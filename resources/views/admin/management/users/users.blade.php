@extends('admin.layouts.app')
@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Users Table</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-row-callback"
                                           class="table table-hover table-bordered table-striped nowrap"
                                           style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Sponsor</th>
                                                <th>Phone</th>
                                                <th>Joining Date</th>
                                                <th>Status</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}<br><em>{{ $user->user_name }}</em></td>

                                                <td><em>{{ $user->sponsor->user_name ?? 'N/A' }}</em></td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ optional($user->created_at)->format('d M, Y') }}</td>

                                                <td>
                                                    <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <!-- Edit -->
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $user->id }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>

                                                    <!-- Delete -->
                                                    <button type="button" class="btn btn-danger delete-btn"
                                                            data-id="{{ $user->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>

                                                    <!-- View -->
                                                    <a href="{{ route('admin.user.view', $user->id) }}" class="btn btn-info" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5>Edit User</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Name</label>
                                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Email</label>
                                                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Phone</label>
                                                                        <input type="text" name="phone" maxlength="10"
                                                                               class="form-control" value="{{ $user->phone }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Alternate Phone</label>
                                                                        <input type="text" name="phone_2" maxlength="10"
                                                                               class="form-control" value="{{ $user->phone_2 }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>State</label>
                                                                        <input type="text" name="state" class="form-control" value="{{ $user->state }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>City</label>
                                                                        <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Zip Code</label>
                                                                        <input type="text" name="zip_code" class="form-control" value="{{ $user->zip_code }}">
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Address</label>
                                                                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


{{-- ✅ Styles --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush


{{-- ✅ Scripts --}}
@push('scripts')
<script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$(document).ready(function () {

    // ✅ Fix: Initialize DataTable ONLY ONCE
    if (!$.fn.DataTable.isDataTable('#datatable-row-callback')) {
        $('#datatable-row-callback').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[0, 'asc']]
        });
    }

    // ✅ Delete - SweetAlert Confirmation
    $('.delete-btn').click(function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('admin/user/delete') }}/${id}`, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(() => {
                    Swal.fire('Deleted!', 'User deleted successfully!', 'success')
                    .then(() => location.reload());
                })
                .catch(() => Swal.fire('Error', 'Something went wrong.', 'error'));
            }
        });
    });

});
</script>
@endpush
