@extends('admin.layouts.app')

@section('content')
    <div id="layout-wrapper">

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="card shadow-lg">
                        <div class="card-header bg-dark text-white d-flex justify-content-between">
                            <h4 class="mb-0">Invoice - {{ $order->custom_order_id }}</h4>
                            <button onclick="window.print()" class="btn btn-light btn-sm">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>

                        <div class="card-body">

                            {{-- Order & User Details --}}
                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <h5 class="fw-bold">Customer Details</h5>
                                    <p class="mb-1"><strong>Name:</strong> {{ $order->user?->name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $order->user?->email }}</p>
                                    <p class="mb-1"><strong>Order Date:</strong>
                                        {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                </div>

                                <div class="col-md-6 text-md-end">
                                    <h5 class="fw-bold">Order Details</h5>
                                    <p class="mb-1"><strong>Order ID:</strong> {{ $order->custom_order_id }}</p>
                                    <p class="mb-1"><strong>Payment Status:</strong>
                                        <span
                                            class="badge
                        @if ($order->payment_status == 'paid') bg-success
                        @elseif($order->payment_status == 'failed') bg-danger
                        @else bg-warning @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </p>
                                    <p class="mb-1"><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
                                </div>

                            </div>



                            {{-- Items Table --}}
                            <h5 class="fw-bold">Order Items</h5>
                            <table class="table table-striped table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price (₹)</th>
                                        <th>Qty</th>
                                        <th>Total (₹)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr class="fw-bold table-info">
                                        <td colspan="4" class="text-end">Grand Total:</td>
                                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
