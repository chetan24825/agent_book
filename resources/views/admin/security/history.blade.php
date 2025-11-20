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
                            <h4 class="mb-0"><i class="mdi mdi-format-list-bulleted me-2"></i> Security Top Refund List
                            </h4>
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

                                                <td>
                                                    {{ $withdraw->is_refundable_date
                                                        ? \Carbon\Carbon::parse($withdraw->is_refundable_date)->format('d M Y, h:i A')
                                                        : '-' }}
                                                </td>


                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary viewBtn"
                                                        data-id="{{ $withdraw->id }}"
                                                        data-name="{{ $withdraw->user?->name }}"
                                                        data-agent="{{ $withdraw->user?->agent_code }}"
                                                        data-agentid="{{ $withdraw->user_id }}"
                                                        data-guard="{{ $withdraw->user_guard }}"
                                                        data-amount="{{ $withdraw->amount }}"
                                                        data-refund="{{ $withdraw->is_refundable }}"
                                                        data-refunddate="{{ $withdraw->is_refundable_date }}"
                                                        data-req="{{ $withdraw->is_refundable_request }}"
                                                        data-reqdate="{{ $withdraw->is_refundable_request_date }}"
                                                        data-utr="{{ $withdraw->utr_id }}"
                                                        data-image="{{ $withdraw->payment_image }}"
                                                        data-remarks="{{ $withdraw->remarks }}"
                                                        data-status="{{ $withdraw->status }}"
                                                        data-date="{{ $withdraw->created_at->format('d M Y, h:i A') }}">
                                                        <i class="mdi mdi-eye"></i> View
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
                    <h5 class="modal-title"><i class="mdi mdi-information-outline me-1"></i> Security Top Refund</h5>
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
                            <th>Refundable</th>
                            <td id="modalRefundable"></td>
                        </tr>
                        <tr>
                            <th>Refundable Date</th>
                            <td id="modalRefundDate"></td>
                        </tr>
                        <tr>
                            <th>Refund Req</th>
                            <td id="modalReq"></td>
                        </tr>
                        <tr>
                            <th>Refund Req Date</th>
                            <td id="modalReqDate"></td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td id="modalRemarks"></td>
                        </tr>
                        <tr>
                            <th>Joining Payment Status</th>
                            <td id="modalStatus"></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="modalDate"></td>
                        </tr>

                    </table>

                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

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

            $("#modalName").text($(this).data("name"));
            $("#modalAgent").text($(this).data("agent"));
            $("#modalAgentId").text($(this).data("agentid"));
            $("#modalGuard").text($(this).data("guard"));
            $("#modalUtr").text($(this).data("utr"));
            $("#modalAmount").text("₹" + $(this).data("amount"));

            $("#modalRefundable").html($(this).data("refund") == 1 ?
                '<span class="badge bg-success">Completed</span>' : "-");
            $("#modalRefundDate").text($(this).data("refunddate") || "-");


            let modalReq = $(this).data("req");

            $("#modalReq").html(
                '<span class="badge bg-secondary">Done</span>'
            );

            $("#modalReqDate").text($(this).data("reqdate") || "-");

            $("#modalRemarks").text($(this).data("remarks") || "No Remarks");

            let status = $(this).data("status");


            $("#modalStatus").html(
                status == 0 ? '<span class="badge bg-info">Pending</span>' :
                status == 1 ? '<span class="badge bg-success">Approved</span>' :
                status == 2 ? '<span class="badge bg-danger">Rejected</span>' :
                '<span class="badge bg-secondary">Completed</span>'
            );




            $("#modalDate").text($(this).data("date"));

            let imageUrl = $(this).data("image");
            if (imageUrl && imageUrl !== "") {
                $("#modalImageBtn").off("click").on("click", function() {
                    window.open(imageUrl, "_blank");
                });
            } else {
                $("#modalImageBtn").off("click").on("click", function() {
                    Swal.fire("No Image", "Payment image not available", "info");
                });
            }

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
@endpush
