@extends('agent.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">🛒 My Cart</h3>
                        <a href="{{ route('agent.products') }}" class="btn btn-primary btn-sm">
                            ← Continue Shopping
                        </a>
                    </div>

                    @if ($globalCartCount > 0)
                        <div class="row">
                            <div class="col-lg-8">

                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Cart Items ({{ $globalCartCount }})</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-hover table-bordered align-middle mb-0">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Image</th>
                                                    <th>Price (₹)</th>
                                                    <th>Quantity</th>
                                                    <th>Total (₹)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody class="text-center">
                                                @php $grandTotal = 0; @endphp

                                                @foreach ($globalCart as $item)
                                                    @php
                                                        $itemTotal = $item['price'] * $item['quantity'];
                                                        $grandTotal += $itemTotal;
                                                    @endphp

                                                    <tr>
                                                        <td class="fw-semibold">{{ $item['name'] }}</td>

                                                        <td>
                                                            <img src="{{ uploaded_asset($item['image']) }}" width="60"
                                                                class="rounded border" alt="">
                                                        </td>

                                                        <td class="fw-semibold">₹{{ number_format($item['price'], 2) }}</td>

                                                        <td style="width: 160px;">
                                                            <form
                                                                action="{{ route('agent.cart.update', $item['product_id']) }}"
                                                                method="POST"
                                                                class="update-qty-form d-flex justify-content-center">
                                                                @csrf
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm qty-minus">−</button>
                                                                <input type="text" name="quantity"
                                                                    value="{{ $item['quantity'] }}"
                                                                    class="form-control text-center mx-2"
                                                                    style="width: 50px;">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm qty-plus">+</button>
                                                            </form>
                                                        </td>

                                                        <td class="fw-bold">₹{{ number_format($itemTotal, 2) }}</td>

                                                        <td>
                                                            <a href="{{ route('agent.cart.remove', $item['product_id']) }}"
                                                                class="btn btn-danger btn-sm">
                                                                Remove
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Order Summary</h5>
                                    </div>

                                    <div class="card-body">

                                        {{-- Total Items --}}
                                        <p class="d-flex justify-content-between">
                                            <span class="fw-semibold">Total Items:</span>
                                            <span>{{ $globalCartCount }}</span>
                                        </p>

                                        <hr>

                                        {{-- Grand Total --}}
                                        <p class="d-flex justify-content-between fs-5 fw-bold">
                                            <span>Grand Total:</span>
                                            <span>₹{{ number_format($grandTotal, 2) }}</span>
                                        </p>

                                        <hr>

                                        {{-- ✅ Checkout Form --}}
                                        <form action="{{ route('agent.checkout') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="checkout_user_guard"
                                                value="{{ old('checkout_user_guard', current_guard()) }}">

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Select Customer <span
                                                        class="text-danger">*</span></label>
                                                <select id="select2-1" name="checkout_user_id"
                                                    class="form-select form-control select2" required>
                                                    <option value="" selected>-- Choose User --</option>
                                                    @foreach ($users as $u)
                                                        <option value="{{ $u->id }}">
                                                            {{ $u->shop_name }} — {{ $u->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Enter Advance Payment <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" step="1.0" required
                                                    name="payment_amount" value="{{ old('payment_amount') }}">
                                            </div>

                                            <button type="submit"
                                                class="btn btn-success btn-lg w-100 rounded-pill shadow-sm">
                                                <i class="fas fa-shopping-cart me-1"></i> Proceed to Checkout
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="alert alert-warning text-center py-4">
                            <h5>Your Cart is Empty</h5>
                            <a href="{{ route('agent.products') }}" class="btn btn-primary mt-2">Browse Products</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('panel/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.qty-plus').click(function() {
                let form = $(this).closest('.update-qty-form');
                let input = form.find('input[name="quantity"]');
                input.val(parseInt(input.val()) + 1);
                form.submit();
            });

            $('.qty-minus').click(function() {
                let form = $(this).closest('.update-qty-form');
                let input = form.find('input[name="quantity"]');
                let value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                    form.submit();
                }
            });

        });
    </script>
@endpush
