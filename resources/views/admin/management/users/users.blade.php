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
                                                    <th>Verification</th>
                                                    <th>Operation</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($users as $index => $user)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $user->name }}<br><em>{{ $user->user_name }}</em></td>

                                                        <td><em>{{ $user->sponsor->name ?? 'N/A' }}</em></td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ optional($user->created_at)->format('d M, Y') }}</td>

                                                        <td>
                                                            <span
                                                                class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if ($user->admin_verification_status == 1)
                                                                <span class="badge bg-success">Verified</span>
                                                            @else
                                                                <span class="badge bg-warning">Not-Verified</span>
                                                            @endif
                                                        </td>

                                                        <td>


                                                            <!-- Delete -->
                                                            <button type="button" class="btn btn-danger delete-btn"
                                                                data-id="{{ $user->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>

                                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                                class="btn btn-primary" target="_blank">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>

                                                            <!-- View -->
                                                            <a href="{{ route('admin.user.view', $user->id) }}"
                                                                class="btn btn-info" target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>


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
    <link rel="stylesheet"
        href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
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
        $(document).ready(function() {

            // ✅ Fix: Initialize DataTable ONLY ONCE
            if (!$.fn.DataTable.isDataTable('#datatable-row-callback')) {
                $('#datatable-row-callback').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    order: [
                        [0, 'asc']
                    ],
                    searching: true, // Enable search functionality
                    language: {
                        paginate: {
                            previous: '<i class="fas fa-angle-left"></i>', // Previous button
                            next: '<i class="fas fa-angle-right"></i>' // Next button
                        }
                    }
                });
            }

            // ✅ Delete - SweetAlert Confirmation
            $('.delete-btn').click(function() {
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
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
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
