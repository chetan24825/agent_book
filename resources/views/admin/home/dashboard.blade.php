@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <div>
                                    @php
                                        $currentHour = \Carbon\Carbon::now()->format('H');

                                        if ($currentHour < 12) {
                                            $greeting = 'Good Morning';
                                        } elseif ($currentHour < 18) {
                                            $greeting = 'Good Afternoon';
                                        } else {
                                            $greeting = 'Good Evening';
                                        }
                                    @endphp
                                    <h4 class="fs-16 fw-semibold mb-1 mb-md-2">{{ $greeting }}, <span
                                            class="text-primary">{{ auth()->user()->name }}</span></h4>
                                    <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                </div>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card bg-danger-subtle"
                                    style="background: url({{ asset('panel/images/dashboard/dashboard-shape-1.png') }}); background-repeat: no-repeat; background-position: bottom center; ">
                                    <div class="card-body">
                                        <a href="">
                                            <div class="d-flex">
                                                <div class="avatar avatar-sm avatar-label-danger">
                                                    <i class="mdi mdi-buffer mt-1"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="text-danger mb-1"> Upcoming Payments</p>
                                                    <h4 class="mb-0 text-dark">

                                                    </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card bg-success-subtle"
                                    style="background: url({{ asset('panel/images/dashboard/dashboard-shape-2.png') }}); background-repeat: no-repeat; background-position: bottom center; ">
                                    <div class="card-body">
                                        <a href="">
                                            <div class="d-flex">
                                                <div class="avatar avatar-sm avatar-label-success">
                                                    <i class="mdi mdi-cash-usd-outline mt-1"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="text-success mb-1">Received Balance</p>
                                                    <h4 class="mb-0 text-dark">

                                                    </h4>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card bg-primary-subtle"
                                    style="background: url({{ asset('panel/images/dashboard/dashboard-shape-2.png') }}); background-repeat: no-repeat; background-position: bottom center; ">
                                    <div class="card-body">
                                        <a href="">
                                            <div class="d-flex">
                                                <div class="avatar avatar-sm avatar-label-primary">
                                                    <i class="mdi mdi-cash-usd-outline mt-1"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <p class="text-primary mb-1">Total Balance</p>
                                                    <h4 class="mb-0 text-dark">

                                                    </h4>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex  justify-content-between">
                                    <h4 class="card-title text-white">Funds Distribution </h4>
                                    <form class="d-flex" action="{{ url()->current() }}" method="get">
                                        <input type="date" class="form-control me-2" id="startDate" name="startDate"
                                            value="{{ request('startDate') }}">
                                        <input type="date" class="form-control me-2" id="endDate" name="endDate"
                                            value="{{ request('endDate') }}">
                                        <button class="btn btn-dark me-2" id="filterButton ">Filter</button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger pt-2 me-2 w-100">Reset</a>

                                    </form>
                                </div>
                                <div class="card-body">
                                    <canvas id="fundsChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
