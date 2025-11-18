@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Title + Back -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">Order Installments — #{{ $order->custom_order_id }}</h3>
                        <a href="{{ route('agent.orders') }}" class="btn btn-dark btn-sm">← Back</a>
                    </div>

                    <!-- SUCCESS / ERROR MESSAGES -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- COMMISSION INFORMATION CARD -->
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h4 class="mb-0"><i class="mdi mdi-cash-multiple me-2"></i>Commission Information</h4>
                        </div>

                        <div class="card-body">
                            <div class="row g-4">

                                <!-- ================= LEFT SIDE ================= -->
                                <div class="col-md-5">

                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-header bg-dark text-white">
                                            <h5 class="mb-0"><i class="mdi mdi-file-document-outline me-2"></i>Order
                                                Details</h5>
                                        </div>

                                        <div class="card-body p-0">
                                            <table class="table table-hover table-bordered mb-0 align-middle">

                                                <tr>
                                                    <th width="40%">Order ID</th>
                                                    <td><strong>{{ $order->custom_order_id }}</strong></td>
                                                </tr>

                                                <tr>
                                                    <th>User Name</th>
                                                    <td>{{ $order->user?->name }}</td>
                                                </tr>

                                                <tr>
                                                    <th>User Email</th>
                                                    <td>{{ $order->user?->email }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Total Amount</th>
                                                    <td><span
                                                            class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Payment Status</th>
                                                    <td>
                                                        <span
                                                            class="badge
                                        @if ($order->payment_status == 'paid') bg-success
                                        @elseif($order->payment_status == 'pending') bg-warning
                                        @else bg-danger @endif">
                                                            {{ ucfirst($order->payment_status) }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Order Status</th>
                                                    <td>
                                                        <span
                                                            class="badge bg-info">{{ ucfirst($order->order_status) }}</span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th>Recieved Amount</th>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            ₹{{ number_format($total_installment - 0, 2) }}</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Remain Amount</th>
                                                    <td>
                                                        <span class="fw-bold text-warning">
                                                            ₹{{ number_format($order->total_amount - $total_installment - 0, 2) }}
                                                        </span>

                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="card shadow border-0 rounded-3">
                                        <div class="card-body text-center">

                                            <h6 class="mb-3 fw-bold text-primary">UPI Payment QR</h6>

                                            <div class="upi-image-box mb-3 mx-auto">
                                                <img id="previewImage"
                                                    src="{{ uploaded_asset(get_setting('upi_scaner')) }}" class="img-fluid"
                                                    alt="UPI QR">
                                            </div>

                                            <a href="https://cfpe.me/kingpinwears" target="_blank"
                                                class="btn btn-gradient w-100 fw-bold mt-2">
                                                <i class="fa fa-credit-card"></i> Pay Now
                                            </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <form action="{{ route('agent.order.installment') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                        <div class="modal-body">

                                            {{-- GLOBAL ERROR ALERT --}}
                                            @if ($errors->any())
                                                <div class="alert alert-danger py-2">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li class="small">{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            {{-- Installment Amount --}}

                                            <div class="mb-3">
                                                <label class="form-label">Installment Amount <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="1.0" name="amount" required
                                                    value="{{ old('amount') }}"
                                                    class="form-control @error('amount') is-invalid @enderror">

                                                @error('amount')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label">Amount UTR ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="utr_id" value="{{ old('utr_id') }}" required
                                                    class="form-control @error('utr_id') is-invalid @enderror">

                                                @error('utr_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="Profile" class="form-label">Payment Image</label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse</div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="payment_image"
                                                        value="{{ old('payment_image') }}" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm"></div>
                                            </div>

                                            {{-- Remarks --}}
                                            {{-- <div class="mb-3">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" rows="3">{{ old('remarks') }}</textarea>

                                                @error('remarks')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div> --}}

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Add Installment</button>
                                            </div>

                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INSTALLMENT STATS -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card shadow-sm text-center p-3">
                                <h5>Total Order Amount</h5>
                                <h3 class="text-primary">₹{{ number_format($order->total_amount, 2) }}</h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm text-center p-3">
                                <h5>Total Installment</h5>
                                <h3 class="text-success">
                                    ₹{{ number_format($total_installment - 0, 2) }}
                                </h3>
                            </div>
                        </div>



                        <div class="col-md-3">
                            <div class="card shadow-sm text-center p-3">
                                <h5>Remaining Balance</h5>
                                <h3>
                                    ₹{{ number_format($order->total_amount - $total_installment - 0, 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- INSTALLMENT LIST -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Installment List</h4>
                        </div>

                        <div class="card-body">
                            <table id="installmentTable"
                                class="table table-bordered table-sm table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($installments as $key => $ins)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td>₹{{ number_format($ins->payment_amount, 2) }}</td>

                                            <td>₹{{ number_format($ins->payment_remain, 2) }}</td>

                                            <td>
                                                @if ($ins->status == 1)
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($ins->status == 2)
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>

                                            <td><em>{{ Str::limit($ins->remarks, 25) }}</em></td>

                                            <td>{{ $ins->created_at->format('d M Y') }}</td>

                                            <td>
                                                <button class="btn btn-sm btn-info viewInstallment"
                                                    data-id="{{ $ins->id }}"
                                                    data-amount="{{ $ins->payment_amount }}"
                                                    data-remain="{{ $ins->payment_remain }}"
                                                    data-status="{{ $ins->status }}" data-remarks="{{ $ins->remarks }}"
                                                    data-utr="{{ $ins->utr_id }}"
                                                    data-paymentby="{{ $ins->payment_by }}"
                                                    data-image="{{ uploaded_asset($ins->payment_image) }}"
                                                    data-date="{{ $ins->created_at->format('d M Y • h:i A') }}">
                                                    View
                                                </button>



                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="modal fade" id="installmentModal" tabindex="-1">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0">

                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="mdi mdi-information-outline me-1"></i> Installment Details
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <table class="table table-bordered mb-0">
                                                <tr>
                                                    <th>Amount</th>
                                                    <td id="viewAmount" class="fw-bold text-success"></td>
                                                </tr>

                                                <tr>
                                                    <th>Remaining</th>
                                                    <td id="viewRemaining" class="fw-bold text-warning"></td>
                                                </tr>

                                                <tr>
                                                    <th>Status</th>
                                                    <td id="viewStatus"></td>
                                                </tr>

                                                <tr>
                                                    <th>Remarks</th>
                                                    <td id="viewRemarks"></td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <td id="viewDate"></td>
                                                </tr>

                                                <tr>
                                                    <th>UTR ID</th>
                                                    <td id="viewUtr"></td>
                                                </tr>

                                                <tr>
                                                    <th>Payment By</th>
                                                    <td id="viewPaymentBy"></td>
                                                </tr>

                                                <tr>
                                                    <th>Image</th>
                                                    <td id="viewImage"></td>
                                                </tr>
                                            </table>

                                        </div>

                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
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
    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #ff1f3d, #bb0a24);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            transition: 0.3s;
        }

        .btn-gradient:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        .upi-image-box {
            width: 180px;
            height: 180px;
            border: 2px dashed #d0d0d0;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
        }

        .upi-image-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.viewInstallment').on('click', function() {

                let amount = $(this).data('amount');
                let remain = $(this).data('remain');
                let status = $(this).data('status');
                let remarks = $(this).data('remarks') || "No remarks";
                let date = $(this).data('date');
                let utr = $(this).data('utr');
                let paymentBy = $(this).data('paymentby');
                let image = $(this).data('image');

                $('#viewAmount').text("₹" + parseFloat(amount).toFixed(2));
                $('#viewRemaining').text("₹" + parseFloat(remain).toFixed(2));

                let badgeHtml =
                    status == 1 ? '<span class="badge bg-success">Paid</span>' :
                    status == 2 ? '<span class="badge bg-danger">Rejected</span>' :
                    '<span class="badge bg-warning text-dark">Pending</span>';

                $('#viewStatus').html(badgeHtml);
                $('#viewRemarks').text(remarks);
                $('#viewDate').text(date);
                $('#viewUtr').text(utr);
                $('#viewPaymentBy').text(paymentBy);

                if (image) {
                    $('#viewImage').html(
                        `<a href="${image}" target="_blank"><img src="${image}" width="90" class="rounded border"></a>`
                    );
                } else {
                    $('#viewImage').text("No Image Uploaded");
                }

                $('#installmentModal').modal('show');
            });

        });
    </script>

    <script>
        document.getElementById("copyUPI").addEventListener("click", function() {
            let copyText = document.getElementById("upiText");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // mobile support

            navigator.clipboard.writeText(copyText.value).then(function() {
                document.getElementById("copyMsg").classList.remove("d-none");

                setTimeout(() => {
                    document.getElementById("copyMsg").classList.add("d-none");
                }, 1500);
            });
        });
    </script>

    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#installmentTable')) {
                $('#installmentTable').DataTable({
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
        });
    </script>
@endpush
