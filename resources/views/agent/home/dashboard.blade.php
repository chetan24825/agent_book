@extends('agent.layouts.app')
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
                                                        {{ App\Models\Orders\Order::where('commission_guard', current_guard())->where('commission_user_id', Auth::id())->count() }}

                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Pending Orders</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::where('commission_guard', current_guard())->where('commission_user_id', Auth::id())->where('order_status', 'pending')->count() }}

                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Completed Orders</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::where('commission_guard', current_guard())->where('commission_user_id', Auth::id())->where('order_status', 'delivered')->count() }}

                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Commission</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::where('commission_guard', current_guard())->where('commission_user_id', Auth::id())->where('commission_status', 1)->sum('total_commission') }}

                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Pending Commission</p>
                                                    <h5 class="mb-0">
                                                        {{ App\Models\Orders\Order::where('commission_guard', current_guard())->where('commission_user_id', Auth::id())->where('commission_status', 1)->sum('total_commission') }}

                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-between align-content-end shadow-lg p-3">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Balance</p>
                                                    <h5 class="mb-0">
                                                        {{ Auth::user()->commission }}
                                                    </h5>
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
        </div>
    </div>
@endsection
