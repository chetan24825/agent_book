@extends('agent.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold text-dark mb-0">
                            <i class="fas fa-check-circle text-success"></i> Thank You!
                        </h3>
                        <a href="{{ route('agent.products') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card shadow-lg border-0 rounded-4">
                                <div class="card-body text-center p-5">

                                    <div class="mb-4">
                                        <i class="fas fa-gift fa-4x text-success"></i>
                                    </div>

                                    <h3 class="fw-bold text-dark mb-3">Your Order Has Been Placed Successfully!</h3>
                                    <p class="text-muted mb-4">
                                        We appreciate your purchase 🎉 <br>
                                        A confirmation email has been sent to your registered email address.
                                    </p>

                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <a href="{{ route('agent.orders') }}" class="btn btn-success">
                                            <i class="fas fa-receipt"></i> View My Orders
                                        </a>

                                        <a href="{{ route('agent.products') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                                        </a>
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
        .fa-check-circle {
            animation: pulse 1s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            from {
                transform: scale(1);
                opacity: 0.8;
            }

            to {
                transform: scale(1.1);
                opacity: 1;
            }
        }
    </style>
@endpush
