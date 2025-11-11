@extends('admin.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success fade show" id="success-alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger fade show" id="success-alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Withdrawals List</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped nowrap" style="width:100%;">
                                    <thead >
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Transaction ID</th>
                                            <th>Withdraw Amount</th>
                                            <th>Balance After</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($withdrawal as $withdraw)
                                            <tr class="text-center align-middle">
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    <strong>{{ $withdraw->user->name }}</strong><br>
                                                    <small class="text-muted">{{ $withdraw->user->user_name }}</small>
                                                </td>

                                                <td>{{ $withdraw->transaction_id }}</td>

                                                <td><span class="badge bg-warning">₹{{ $withdraw->amount }}</span></td>

                                                <td><span class="badge bg-success">₹{{ $withdraw->balance_amount }}</span>
                                                </td>

                                                <td>
                                                    @if ($withdraw->status == 0)
                                                        <span class="badge bg-info">Pending</span>
                                                    @elseif ($withdraw->status == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('admin.withdraws.view', $withdraw->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No withdrawals found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div> {{-- container-fluid --}}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // ✅ Prevent DataTable re-initialization
            if (!$.fn.DataTable.isDataTable('#datatable-row-callback')) {
                $('#datatable-row-callback').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    searching: true, // Enable search functionality
                    language: {
                        paginate: {
                            previous: '<i class="fas fa-angle-left"></i>', // Previous button
                            next: '<i class="fas fa-angle-right"></i>' // Next button
                        }
                    }
                });
            }

            // ✅ Auto hide alert
            setTimeout(() => {
                $('#success-alert').fadeOut('slow');
            }, 1500);

        });
    </script>
@endpush
