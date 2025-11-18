@extends('user.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">🛒 My Cart</h3>
                        <a href="{{ route('user.products') }}" class="btn btn-primary btn-sm">
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
                                                    <th>Note</th>
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
                                                        <td class="fw-semibold">{{ $item['name'] }}


                                                        </td>

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

                                                        <td class="fw-bold">
                                                            <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                                title="{{ $item['message'] }}">
                                                                {{ Str::limit($item['message'] ?? '', 40, '...') }}
                                                            </em>
                                                        </td>

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
                                        <p class="d-flex justify-content-between">
                                            <span class="fw-semibold">Total Items:</span>
                                            <span>{{ $globalCartCount }}</span>
                                        </p>

                                        <hr>

                                        <p class="d-flex justify-content-between fs-5 fw-bold">
                                            <span>Grand Total:</span>
                                            <span>₹{{ number_format($grandTotal, 2) }}</span>
                                        </p>


                                        {{--
                                        <form action="{{ route('user.checkout') }}" method="POST">
                                            @csrf
                                            <hr>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Enter Advance Payment <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" step="1.0" required
                                                    name="payment_amount" value="{{ old('payment_amount') }}">
                                            </div>
                                            <button class="btn btn-success btn-lg w-100">Proceed to Checkout</button>
                                        </form> --}}



                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Main Card --}}
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="mdi mdi-credit-card-outline me-2"></i> Payment Checkout</h4>
                            </div>

                            <div class="card-body py-4">
                                <div class="row g-4">



                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    @endif


                                    <div class="col-lg-5">
                                        <div class="card border-0 shadow-sm rounded-3 h-100">
                                            <div class="card-body text-center">
                                                <h5 class="fw-bold text-primary mb-3">Scan & Pay Using UPI</h5>

                                                <div class="upi-image-box mx-auto mb-3">
                                                    <img src="{{ uploaded_asset(get_setting('upi_scaner')) }}"
                                                        alt="UPI QR" class="img-fluid">
                                                </div>

                                                <a href="https://cfpe.me/kingpinwears" target="_blank"
                                                    class="btn btn-gradient w-100 fw-bold py-2 rounded-pill mt-2">
                                                    <i class="fa fa-credit-card me-1"></i> Pay via Link
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Right: Form --}}
                                    <div class="col-lg-7">
                                        <div class="card border-0 shadow-sm rounded-3 h-100">
                                            <div class="card-body">

                                                <h5 class="fw-bold mb-3 text-dark">Enter Payment Details</h5>

                                                <form action="{{ route('user.checkout') }}" method="POST">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Advance Amount <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" name="payment_amount" class="form-control"
                                                            value="{{ old('payment_amount') }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">UTR ID <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="utr_id" value="{{ old('utr_id') }}"
                                                            class="form-control @error('utr_id') is-invalid @enderror"
                                                            required>
                                                        @error('utr_id')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Payment Proof Image</label>
                                                        <div class="input-group" data-toggle="aizuploader"
                                                            data-type="image">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text bg-soft-secondary">Browse
                                                                </div>
                                                            </div>
                                                            <div class="form-control file-amount">Choose Image</div>
                                                            <input type="hidden" name="payment_image"
                                                                value="{{ old('payment_image') }}"
                                                                class="selected-files">
                                                        </div>
                                                        <div class="file-preview box sm"></div>
                                                    </div>

                                                    <button type="submit"
                                                        class="btn btn-success w-100 py-2 fw-bold rounded-pill mt-3 shadow-sm">
                                                        <i class="fas fa-check-circle me-1"></i> Confirm & Checkout
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center py-4">
                            <h5>Your Cart is Empty</h5>
                            <a href="{{ route('user.products') }}" class="btn btn-primary mt-2">Browse Products</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #ff1f3d, #bb0a24);
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-gradient:hover {
            opacity: .85;
            transform: translateY(-2px);
        }

        .upi-image-box {
            width: 200px;
            height: 200px;
            border: 2px dashed #d6d6d6;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: #fafafa;
        }
    </style>
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
