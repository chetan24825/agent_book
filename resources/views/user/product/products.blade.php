@extends('user.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" id="success-alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">

                        <div class="card-header bg-primary d-flex justify-content-between align-items-center position-sticky top-0  shadow"
                            style="z-index: 0;">
                            <h4 class="card-title">List Of Products</h4>
                            <div class="d-flex justify-content-end">

                                <a href="#" class="btn btn-dark pt-2">
                                    <i class="fas fa-shopping-cart me-1"></i> Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row g-4">
                                @foreach ($products as $product)
                                    <div class="col-md-3 col-6">
                                        <div class="product-card p-3 text-center">

                                            {{-- Product Image --}}
                                            <img src="{{ uploaded_asset($product->thumbphotos) }}" class="product-img mb-3">

                                            {{-- Name --}}
                                            <h6 class="text-uppercase fw-semibold">
                                                {{ Str::limit($product->product_name, 18) }}
                                            </h6>

                                            {{-- Price --}}
                                            <p class="mb-1 text-dark fw-bold">₹{{ number_format($product->sale_price, 2) }}
                                            </p>

                                            {{-- Stock --}}
                                            <p class="fw-bold {{ $product->in_stock ? 'text-success' : 'text-danger' }}">
                                                {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                                            </p>

                                            {{-- Add to Cart Button --}}
                                            <button class="btn avail-btn w-100 addCartBtn" data-id="{{ $product->id }}"
                                                data-name="{{ $product->product_name }}"
                                                data-price="{{ $product->sale_price }}"
                                                data-img="{{ uploaded_asset($product->thumbphotos) }}">
                                                <i class="fas fa-shopping-bag me-1"></i> AVAIL NOW
                                            </button>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ✅ Add to Cart Modal --}}
    <div class="modal fade" id="addCartModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content add-cart-modal">

                <form id="addCartForm">
                    @csrf

                    <div class="modal-header border-0">
                        {{-- <h5 class="fw-bold text-success">Add to Cart</h5> --}}
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">

                        <input type="hidden" name="product_id" id="modalProductId">

                        {{-- IMAGE --}}
                        <img id="modalProductImg" class="product-modal-img mb-2">

                        {{-- NAME --}}
                        <h6 class="fw-bold" id="modalProductName"></h6>

                        {{-- PRICE --}}
                        <p class="price-text">₹ <span id="modalProductPrice"></span></p>

                        {{-- QUANTITY --}}
                        <label class="fw-semibold mt-3">Quantity</label>
                        <div class="quantity-box mb-3">
                            <button type="button" class="qty-btn" id="qtyMinus">−</button>
                            <input type="number" class="form-control qty-input" id="qtyInput" name="quantity"
                                min="1" value="1">
                            <button type="button" class="qty-btn" id="qtyPlus">+</button>
                        </div>


                        <div class="modal-footer border-0">
                            <button type="submit" class="btn confirm-cart-btn w-100">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                        </div>

                    </div>



                </form>

            </div>
        </div>
    </div>
@endsection


{{-- ✅ Styles --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">

    <style>
        .product-card {
            border: 2px dashed #1FA25F;
            border-radius: 12px;
            background: white;
            transition: .3s;
        }

        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            height: 120px;
            width: 100%;
            object-fit: contain;
        }

        .avail-btn {
            background: #1FA25F;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
        }

        .avail-btn:hover {
            background: #15864C;
        }

        .add-cart-modal {
            border-radius: 16px;
        }

        .product-modal-img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }

        .price-text {
            font-size: 20px;
            font-weight: 700;
            color: #1FA25F;
        }

        .quantity-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .qty-btn {
            width: 38px;
            height: 38px;
            background: #e4e7eb;
            border: none;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 700;
        }

        .qty-input {
            width: 70px;
            text-align: center;
            font-weight: 600;
        }

        .confirm-cart-btn {
            background: #1FA25F;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
        }

        .confirm-cart-btn:hover {
            background: #15864C;
        }
    </style>
@endpush


{{-- ✅ Scripts --}}
@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            setTimeout(() => {
                $('#success-alert').alert('close');
            }, 2000);

            $('.addCartBtn').click(function() {
                $('#modalProductId').val($(this).data('id'));
                $('#modalProductName').text($(this).data('name'));
                $('#modalProductPrice').text($(this).data('price'));
                $('#modalProductImg').attr('src', $(this).data('img'));
                $('#addCartModal').modal('show');
            });

            $('#qtyPlus').click(() => $('#qtyInput').val(parseInt($('#qtyInput').val()) + 1));
            $('#qtyMinus').click(() => {
                let q = parseInt($('#qtyInput').val());
                if (q > 1) {
                    $('#qtyInput').val(q - 1);
                }
            });

            $('#addCartForm').submit(function(e) {
                e.preventDefault();
                $.post("{{ route('agent.cart.add') }}", $(this).serialize(), function() {
                    $('#addCartModal').modal('hide');
                    Swal.fire('Added!', 'Product added to cart successfully!', 'success');
                }).fail(() => Swal.fire('Error!', 'Something went wrong.', 'error'));
            });

        });
    </script>
@endpush
