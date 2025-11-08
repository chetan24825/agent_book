@extends('user.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-primary alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <br>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h2 class="card-title text-white">Order Status</h2>
                                </div>

                                <div class="card-body">
                                    <div class="row">

                                        <!-- MRP Price -->
                                        <div class="col-md-6">
                                            <label for="order_id" class="form-label">Order Id <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="order_id" name="order_id"
                                                value="{{ old('order_id', $order->order_id) }}" disabled />
                                            @error('order_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="payment_method" class="form-label">Payment Method <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="payment_method" disabled
                                                value="{{ old('payment_method', $order->payment_method) }}">
                                            @error('payment_method')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- status -->
                                        <div class="col-md-6">
                                            <label for="payment_status" class="form-label mt-3">Payment Status <span
                                                    class="text-danger">*</span></label>

                                            <input type="text" class="form-control" name="payment_status" disabled
                                                value="{{ old('payment_status', $order->payment_status) }}">

                                            @error('payment_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="delivery_by" class="form-label mt-3">Delivery By <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="delivery_by" disabled
                                                value="{{ old('delivery_by', $order->delivery_by) }}">
                                            @error('delivery_by')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-6">
                                            <label for="offer_product" class="form-label mt-3">Delivery Status <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="status" disabled
                                                value="{{ old('status', $order->status) }}">
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($shipping)
                            <div class="col-xl-6">
                                <div class="card ">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white"> Shipping Address</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <input type="text" name="ship_name" class="form-control"
                                                    placeholder="Full Name" value="{{ $shipping->name ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="text" name="ship_phone" class="form-control"
                                                    placeholder="Phone" value="{{ $shipping->phone ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <textarea name="ship_address" class="form-control" placeholder="Address" disabled>{{ $shipping->address ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <input type="text" name="ship_city" class="form-control"
                                                    placeholder="City" value="{{ $shipping->town ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <input type="text" name="ship_state" class="form-control"
                                                    placeholder="State" value="{{ $shipping->state ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <input type="text" name="ship_pincode" class="form-control"
                                                    placeholder="Pincode" value="{{ $shipping->pincode ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h2 class="card-title text-white">Product Detail</h2>
                                </div>


                                <div class="card-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @if (!empty($order->products))
                                                    @foreach (json_decode($order->products, true) ?? [] as $item)
                                                        <tr>
                                                            <td data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ $item['product_name'] ?? '' }}">
                                                                {{ Str::limit($item['product_name'] ?? 'N/A', 20, '...') }}
                                                            </td>
                                                            <td>{{ $item['quantity'] ?? 0 }}</td>
                                                            <td>{{ $item['rate'] ?? 0 }}</td>
                                                            <td>{{ $item['net_amount'] ?? 0 }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if (!empty($order->package))
                                                    @foreach (json_decode(is_string($order->package) ? $order->package : json_encode($order->package), true) ?? [] as $item)
                                                        <tr>
                                                            <td data-bs-toggle="tooltip"
                                                                data-bs-original-title="{{ $item['package_name'] ?? '' }}">
                                                                {{ Str::limit($item['package_name'] ?? 'N/A', 20, '...') }}
                                                            </td>
                                                            <td>{{ $item['quantity'] ?? 0 }}</td>
                                                            <td>{{ $item['net_amount'] ?? 0 }}</td>
                                                            <td>{{ $item['net_amount'] ?? 0 }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="3" class="text-end">Sub Total</td>
                                                    <td>{{ $order->net_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end">Gst Tax (include)</td>
                                                    <td>{{ $order->gst_tax }}</td>
                                                </tr>

                                                @if ($order->coupon_code_amount > 0)
                                                    <tr>
                                                        <td colspan="3" class="text-end">Coupon Code
                                                            ({{ $order->coupon_code }})</td>
                                                        <td>{{ $order->coupon_code_amount }}</td>

                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="3" class="text-end">Main Amount</td>
                                                    <td>{{ $order->main_amount }}</td>

                                                </tr>
                                            </tbody>
                                        </table>
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
