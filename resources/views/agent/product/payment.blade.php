@extends('agent.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- Alerts --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow-lg rounded-4">
                        <div
                            class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold"><i class="mdi mdi-shield-check-outline me-2"></i>Security Deposit</h4>
                        </div>

                        <div class="card-body p-4">


                            <div class="alert alert-warning border-0 shadow-sm rounded-3 p-4 mb-4"
                                style="font-size: 15px; line-height: 1.6;">
                                <h5 class="fw-bold text-dark mb-2">
                                    <i class="mdi mdi-alert-circle-outline text-warning me-1"></i>
                                    Important Notice — Security Deposit ₹{{ get_setting('security_deposit') }} (Refundable)
                                </h5>

                                <p class="mb-0">
                                    A refundable <strong>₹1000 security deposit</strong> is collected because the company
                                    provides
                                    valuable visual kits and premium clothing sample items for work purposes.
                                    <br><br>
                                    When you resign, you must return all issued items in <strong>good condition</strong>.
                                    After return verification, your full deposit amount will be refunded.
                                </p>
                            </div>



                            @if (isset($security->remarks) && $security->status !== 3)
                                <div class="text-center">
                                    <p class="mt-2 fw-bold">Admin Message</p>
                                    <div class="alert alert-warning text-center fw-semibold mb-4">
                                        {{ $security->remarks }}
                                    </div>
                                </div>
                            @endif

                            @php
                                $status = $security->status ?? 3; //0 = pending, 1 = approved, 2 = rejected ,3 = completed
                            @endphp

                            @switch($status)
                                {{-- ---------------- APPROVED ---------------- --}}
                                @case(1)
                                    @if ($security->is_refundable_request == 1)
                                        <div class="alert alert-warning text-center fw-semibold mb-4">
                                            Refund Request Submitted — Waiting for Admin Approval
                                        </div>

                                        <div class="text-center py-3">
                                            <i class="fa fa-spinner fa-spin fa-2x text-warning"></i>
                                            <p class="mt-2 fw-bold">Under Review</p>
                                        </div>
                                    @else
                                        <div class="alert alert-success text-center fw-semibold mb-4">
                                            Security Deposit Approved
                                        </div>

                                        <form action="{{ route('agent.security.refund') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $security->id }}">
                                            <input type="hidden" name="is_refundable_request" value="1">

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Deposit Amount</label>
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($security->amount, 0) }}" readonly>
                                            </div>

                                            <button class="btn btn-danger w-100 fw-bold rounded-pill py-2">
                                                <i class="mdi mdi-cash-refund me-1"></i> Request Refund
                                            </button>
                                        </form>
                                    @endif
                                @break

                                {{-- @case(2)
                                    @if ($security->is_refundable_request == 1)
                                        <div class="alert alert-warning text-center fw-semibold mb-4">
                                            Refund Request Submitted — Waiting for Admin Approval
                                        </div>

                                        <div class="text-center py-3">
                                            <i class="fa fa-spinner fa-spin fa-2x text-warning"></i>
                                            <p class="mt-2 fw-bold">Under Review</p>
                                        </div>
                                    @else
                                        <div class="alert alert-success text-center fw-semibold mb-4">
                                            Security Deposit Approved
                                        </div>


                                        <form action="{{ route('agent.security.refund') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $security->id }}">
                                            <input type="hidden" name="is_refundable_request" value="1">

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Deposit Amount</label>
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($security->amount, 0) }}" readonly>
                                            </div>

                                            <button class="btn btn-danger w-100 fw-bold rounded-pill py-2">
                                                <i class="mdi mdi-cash-refund me-1"></i> Request Refund
                                            </button>
                                        </form>
                                    @endif
                                @break --}}

                                {{-- ---------------- PENDING ---------------- --}}
                                @case(0)
                                    <div class="alert alert-warning text-center fw-semibold mb-4">
                                        Your payment is pending. Please wait for admin approval.
                                    </div>

                                    <div class="text-center py-3">
                                        <i class="fa fa-spinner fa-spin fa-2x text-warning"></i>
                                        <p class="mt-2 fw-bold">Under Review</p>
                                    </div>
                                @break

                                {{-- ---------------- REJECTED / NEW PAYMENT / NULL ---------------- --}}

                                @default
                                    <div class="row g-4">

                                        {{-- QR + LINK --}}
                                        <div class="col-lg-5">
                                            <div class="card shadow-sm border-0 h-100 rounded-3">
                                                <div class="card-body text-center">
                                                    <h5 class="fw-bold text-primary">Scan & Pay via UPI</h5>
                                                    <div class="upi-box mx-auto my-3">
                                                        <img src="{{ uploaded_asset(get_setting('upi_scaner')) }}" class="img-fluid"
                                                            alt="UPI QR">
                                                    </div>

                                                    <a href="https://cfpe.me/kingpinwears" target="_blank"
                                                        class="btn btn-gradient w-100 fw-bold rounded-pill">
                                                        <i class="fa fa-credit-card me-1"></i> Pay Online
                                                    </a>
                                                </div>






                                            </div>
                                        </div>

                                        {{-- PAYMENT FORM --}}
                                        <div class="col-lg-7">
                                            <div class="card shadow-sm border-0 h-100 rounded-3">
                                                <div class="card-body">

                                                    <h5 class="fw-bold text-dark mb-3">Upload Payment Details</h5>

                                                    <form action="{{ route('agent.security') }}" method="POST">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Deposit Amount</label>
                                                            <input type="number" value="{{ get_setting('security_deposit') }}"
                                                                name="payment_amount" class="form-control" readonly>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">UTR ID</label>
                                                            <input type="text" name="utr_id"
                                                                class="form-control @error('utr_id') is-invalid @enderror" required>
                                                            @error('utr_id')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Payment Proof</label>
                                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                <span class="input-group-text bg-light">Browse</span>
                                                                <div class="form-control file-amount">Choose Image</div>
                                                                <input type="hidden" name="payment_image" class="selected-files">
                                                            </div>
                                                            <div class="file-preview box sm"></div>
                                                        </div>

                                                        <button type="submit"
                                                            class="btn btn-success w-100 rounded-pill fw-bold py-2">
                                                            <i class="fas fa-check-circle me-1"></i> Submit Payment
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @break
                            @endswitch

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #ff1f3d, #bb0a24);
            color: #fff !important;
            border-radius: 8px;
            transition: .3s;
        }

        .btn-gradient:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        .upi-box {
            width: 220px;
            height: 220px;
            border: 2px dashed #ccc;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            padding: 10px;
        }
    </style>
@endsection
