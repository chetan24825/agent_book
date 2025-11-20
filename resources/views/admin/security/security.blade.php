@extends('admin.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" id="flash-alert">
                            <strong><i class="mdi mdi-check-circle-outline me-1"></i>Success:</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" id="flash-alert">
                            <strong><i class="mdi mdi-alert-circle-outline me-1"></i>Error:</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Main Card --}}
                    <div class="card shadow-lg border-0 rounded-4">
                        <div
                            class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center rounded-top">
                            <h4 class="mb-0"><i class="mdi mdi-format-list-bulleted me-2"></i> Security Top List</h4>
                            <span class="badge bg-light text-dark px-3 py-2">{{ $security->count() }} Records</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-security"
                                    class="table align-middle table-hover table-striped table-bordered text-center nowrap"
                                    style="width:100%;">

                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>UTR ID</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($security as $withdraw)
                                            <tr>
                                                <td class="fw-bold">{{ $loop->iteration }}</td>

                                                <td>
                                                    <strong>{{ $withdraw->user?->name }}</strong><br>
                                                    <small class="text-muted">{{ $withdraw->user?->agent_code }}</small>
                                                </td>

                                                <td class="fw-bold text-dark">{{ $withdraw->utr_id }}</td>

                                                <td class="fw-bold text-success">₹{{ number_format($withdraw->amount, 2) }}
                                                </td>

                                                <td>
                                                    @if ($withdraw->status == 0)
                                                        <span class="badge bg-info">Pending</span>
                                                    @elseif ($withdraw->status == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($withdraw->status == 2)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-secondary">Completed</span>
                                                    @endif
                                                </td>

                                                <td>{{ optional($withdraw->created_at)->format('d M Y, h:i A') }}</td>

                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary viewBtn"
                                                        data-id="{{ $withdraw->id }}"
                                                        data-name="{{ $withdraw->user?->name }}"
                                                        data-agent="{{ $withdraw->user?->agent_code }}"
                                                        data-amount="{{ $withdraw->amount }}"
                                                        data-utr="{{ $withdraw->utr_id }}"
                                                        data-status="{{ $withdraw->status }}"
                                                        data-image="{{ $withdraw->payment_image ? uploaded_asset($withdraw->payment_image) : '' }}"
                                                        data-date="{{ $withdraw->created_at->format('d M Y, h:i A') }}">
                                                        <i class="mdi mdi-eye"></i> View
                                                    </button>


                                                    <button class="btn btn-sm btn-outline-success approveBtn"
                                                        data-id="{{ $withdraw->id }}"
                                                        data-name="{{ $withdraw->user?->name }}"
                                                        data-amount="{{ $withdraw->amount }}">
                                                        <i class="mdi mdi-check"></i> Approve
                                                    </button>

                                                    <button class="btn btn-sm btn-outline-danger rejectBtn"
                                                        data-id="{{ $withdraw->id }}"
                                                        data-name="{{ $withdraw->user?->name }}">
                                                        <i class="mdi mdi-close"></i> Reject
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            {{-- <tr>
                                                <td colspan="7" class="text-center text-muted py-3 fw-bold">
                                                    <i class="mdi mdi-information-outline fs-4 me-1"></i>No records found
                                                </td>
                                            </tr> --}}
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="withdrawModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-3">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="mdi mdi-information-outline me-1"></i> Security Top Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td id="modalName"></td>
                        </tr>
                        <tr>
                            <th>Agent Code</th>
                            <td id="modalAgent"></td>
                        </tr>
                        <tr>
                            <th>UTR ID</th>
                            <td id="modalUtr"></td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td id="modalAmount"></td>
                        </tr>



                        <tr>
                            <th>Status</th>
                            <td id="modalStatus"></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="modalDate"></td>
                        </tr>

                        <tr>
                            <th>Payment Image</th>
                            <td>
                                <img id="modalImage" src="" alt="Payment Proof"
                                    style="width:100px; height:100px; object-fit:contain; border:1px solid #ddd; border-radius:6px; display:none;">
                                <span id="noImageText" class="text-danger fw-bold">No Image Available</span>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection




@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">

    <style>
        .table-hover tbody tr:hover {
            background: #f3f6ff;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).on("click", ".viewBtn", function() {

            let image = $(this).data("image");

            if (image) {
                $("#modalImage").attr("src", image).show();
                $("#modalImage").css("cursor", "pointer");
                $("#modalImage").off("click").on("click", function() {
                    window.open(image, "_blank");
                });

                $("#noImageText").hide();
            } else {
                $("#modalImage").hide();
                $("#noImageText").show();
            }

            $("#modalName").text($(this).data("name"));
            $("#modalAgent").text($(this).data("agent"));
            $("#modalUtr").text($(this).data("utr"));
            $("#modalAmount").text("₹" + $(this).data("amount"));
            $("#modalDate").text($(this).data("date"));

            let status = $(this).data("status");
            let statusBadge =
                status == 0 ? '<span class="badge bg-info">Pending</span>' :
                status == 1 ? '<span class="badge bg-success">Approved</span>' :
                status == 2 ? '<span class="badge bg-danger">Rejected</span>' :
                '<span class="badge bg-secondary">Completed</span>';

            $("#modalStatus").html(statusBadge);

            $("#withdrawModal").modal("show");
        });




        $(document).ready(function() {

            if (!$.fn.DataTable.isDataTable('#datatable-security')) {
                $('#datatable-security').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    language: {
                        emptyTable: "No data available",
                        searchPlaceholder: "Search records...",

                        paginate: {
                            previous: '<i class="fas fa-angle-left"></i>',
                            next: '<i class="fas fa-angle-right"></i>'
                        }
                    },
                    columnDefs: [{
                        targets: '_all',
                        defaultContent: '-'
                    }]
                });
            }

            setTimeout(() => {
                $('#flash-alert').fadeOut('slow');
            }, 2000);

        });
    </script>

    <script>
        $(document).ready(function() {

            // APPROVE BUTTON ACTION
            $(document).on("click", ".approveBtn", function() {
                let id = $(this).data("id");
                let amount = $(this).data("amount");
                let name = $(this).data("name");

                Swal.fire({
                    title: "Approve Refund?",
                    html: `<b>${name}</b><br>Amount: ₹${amount}`,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Approve"
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus(id, 1);
                    }
                });
            });

            // REJECT BUTTON ACTION
            $(document).on("click", ".rejectBtn", function() {
                let id = $(this).data("id");
                let name = $(this).data("name");

                Swal.fire({
                    title: "Reject Refund?",
                    html: `<b>${name}</b>`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#555",
                    confirmButtonText: "Reject"
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus(id, 2);
                    }
                });
            });

            // AJAX REQUEST
            function updateStatus(id, status) {
                $.ajax({
                    url: "{{ route('admin.security.update') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    beforeSend() {
                        Swal.showLoading();
                    },
                    success: function(response) {

                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 1200);
                    },
                    error: function() {
                        Swal.fire("Error", "Something went wrong", "error");
                    }
                });
            }

        });
    </script>
@endpush
