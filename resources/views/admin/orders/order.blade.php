@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- ✅ Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="success-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary">
                            <h4 class="card-title text-white">Orders List</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-orders"   class="table table-bordered table-striped nowrap"
                                    style="width:100%;">
                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Sponsor</th>
                                            <th>Total Amount</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Commission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="text-center align-middle">
                                                <td>{{ $loop->iteration }}</td>

                                                <td class="fw-bold">{{ $order->custom_order_id ?? 'N/A' }}</td>

                                                <td>
                                                    {{ $order->user?->shop_name ?? '' }} <br>
                                                    <small class="text-muted">

                                                        {{ $order->user?->name ?? 'N/A' }}
                                                    </small>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge bg-success">{{ $order->sponsor?->agent_code ?? 'N/A' }}</span>
                                                </td>

                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>

                                                <td>
                                                    <span
                                                        class="badge
                                                @if ($order->payment_status == 'paid') bg-success
                                                @elseif($order->payment_status == 'failed') bg-danger
                                                @else bg-warning @endif">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge
                                                @if ($order->order_status == 'delivered') bg-success
                                                @elseif($order->order_status == 'shipped') bg-primary
                                                @elseif($order->order_status == 'cancelled') bg-danger
                                                @else bg-secondary @endif">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>


                                                <td>₹{{ number_format($order->total_commission, 2) }}</td>

                                                <td>
                                                    <a href="{{ route('admin.order.invoice', $order->id) }}"
                                                        class="btn btn-info btn-sm">View</a>

                                                    <a href="{{ route('admin.order.edit', $order->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>

                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $order->id }}">
                                                        Delete
                                                    </button>



                                                    @php
                                                        $pendingCount = order_installment_pending($order->id);
                                                    @endphp

                                                    <a href="{{ route('admin.order.commission', $order->id) }}"
                                                        class="btn btn-dark position-relative">
                                                        Installments

                                                        @if ($pendingCount > 0)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                {{ $pendingCount }}
                                                            </span>
                                                        @endif
                                                    </a>


                                                </td>

                                            </tr>
                                        @endforeach
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


{{-- ✅ STYLES --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush


{{-- ✅ SCRIPTS --}}
@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // ✅ Prevent DataTable reinitialization
            if (!$.fn.DataTable.isDataTable('#datatable-orders')) {
                $('#datatable-orders').DataTable({
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

            // ✅ Auto fade alert
            setTimeout(() => {
                $('#success-alert').fadeOut('slow');
            }, 2000);

            // ✅ Delete Confirmation
            $('.delete-btn').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Delete Order?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('admin/order/delete') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).then(() => {
                            Swal.fire('Deleted!', 'Order has been removed.', 'success');
                            setTimeout(() => location.reload(), 800);
                        });
                    }
                });
            });

        });
    </script>
@endpush
