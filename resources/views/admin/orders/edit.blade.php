@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4>Edit Order - {{ $order->custom_order_id }}</h4>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                                @csrf

                                <div class="row">

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">User Name</label>
                                        <input type="text" class="form-control" value="{{ $order->user?->name }}"
                                            disabled>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">User Email</label>
                                        <input type="text" class="form-control" value="{{ $order->user?->email }}"
                                            disabled>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Total Amount</label>
                                        <input type="text" class="form-control"
                                            value="₹{{ number_format($order->total_amount, 2) }}" disabled>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-semibold">Payment Status</label>
                                        <select name="payment_status" class="form-control" required>
                                            <option value="pending"
                                                {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                                Paid</option>
                                            <option value="failed"
                                                {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-semibold">Order Status</label>
                                        <select name="order_status" class="form-control" required>
                                            <option value="pending"
                                                {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed"
                                                {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                            </option>
                                            <option value="shipped"
                                                {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered"
                                                {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <hr>
                                <h5 class="fw-bold">Commission Information</h5>
                                <hr>

                                <div class="row">

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Sponsor Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $order->sponsor?->name ?? 'N/A' }}" disabled>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Sponsor Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ $order->sponsor?->email ?? 'N/A' }}" disabled>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Commission Amount</label>
                                        <input type="text" class="form-control" name="total_commission"
                                            {{ $order->commission_status == 1 ? 'disabled' : '' }}
                                            value="{{ number_format($order->total_commission, 2) }}">
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-semibold">Commission Guard</label>
                                        <input type="text" class="form-control"
                                            value="{{ $order->commission_guard ?? 'N/A' }}" disabled>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-semibold">Commission Date</label>
                                        <input type="text" class="form-control" value="{{ $order->commission_date }}"
                                            readonly>
                                    </div>


                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-semibold">Apply Commission?</label>
                                        <select name="commission_status" class="form-control"
                                            {{ $order->commission_status == 1 ? 'disabled' : '' }}>
                                            <option value="0" {{ $order->commission_status == 0 ? 'selected' : '' }}>
                                                No</option>
                                            <option value="1" {{ $order->commission_status == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                        </select>
                                    </div>


                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success px-4">Update Order</button>
                                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Back</a>
                                </div>

                            </form>
                        </div>

                    </div>


                    {{-- Order Items --}}
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Order Items</h5>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="table-light">
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
                                            <td>{{ $item->price }}</td>
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
