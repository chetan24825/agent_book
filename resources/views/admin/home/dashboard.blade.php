@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon">
                                            <i class="fas fa-cart-plus fs-14 text-muted"></i>
                                        </div>
                                        <h4 class="card-title mb-0 ms-2">Dashboard</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Orders</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::count() }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Sale</p>
                                                    <h5 class="mb-0">
                                                       {{ App\Models\Orders\Order::sum('total_amount') }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Commission</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::sum('total_commission') }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- <div class="row">
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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
