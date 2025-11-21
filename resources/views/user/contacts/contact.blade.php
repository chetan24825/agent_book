@extends('user.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold text-dark mb-0">
                            <i class="fas fa-headset text-success"></i> Contact Support
                        </h3>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="card shadow-lg border-0 rounded-4">
                                <div class="card-body text-center p-5">

                                    <div class="mb-4">
                                        <i class="fas fa-phone-volume fa-4x text-success"></i>
                                    </div>

                                    <h3 class="fw-bold text-dark mb-3">We’re here to assist you</h3>
                                    <p class="text-muted mb-4">
                                        Kindly contact the support team using the following official details.
                                    </p>

                                    <hr>

                                    <ul class="list-unstyled contact-details text-start mt-4">

                                        <li class="mb-3">
                                            <strong><i class="fas fa-user-tie text-success me-2"></i> Support
                                                Person:</strong>
                                            <span>{{ get_setting('company_name') ?? 'KINGPIN SUPPORT TEAM' }}</span>
                                        </li>

                                        <li class="mb-3">
                                            <strong><i class="fas fa-phone text-success me-2"></i> Phone:</strong>
                                            <span>{{ get_setting('company_phone') ?? '+91 98765 43210' }}</span>
                                        </li>

                                        <li class="mb-3">
                                            <strong><i class="fas fa-envelope text-success me-2"></i> Email:</strong>
                                            <span>{{ get_setting('company_email') ?? 'support@kingpinwears.com' }}</span>
                                        </li>

                                        <li class="mb-3">
                                            <strong><i class="fas fa-map-marker-alt text-success me-2"></i>
                                                Address:</strong>
                                            <span>{{ get_setting('company_address') ?? '123 Business Park, Delhi, India' }}</span>
                                        </li>

                                        {{-- <li class="mb-3">
                                            <strong><i class="fas fa-globe text-success me-2"></i> Website:</strong>
                                            <span>{{ config('app.url', 'www.kingpinwears.com') }}</span>
                                        </li> --}}

                                    </ul>

                                    <hr>

                                    <p class="text-muted mt-3">Support Hours: <strong>Mon–Sat, 10AM – 6PM</strong></p>

                                    <a href="tel:{{ get_setting('company_phone') }}"
                                        class="btn btn-success w-100 mt-3 fw-bold rounded-pill py-2">
                                        <i class="fas fa-phone me-2"></i> Call Support
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
