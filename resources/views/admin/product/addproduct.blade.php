@extends('admin.layouts.app')
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
                    <form class="row g-3" action="{{ route('admin.product.save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Add Product</h2>
                                    </div>

                                    <div class="card-body">


                                        <!-- Category Dropdown -->
                                        <div class="col-md-12 position-relative">
                                            <label for="Category"
                                                class="form-label d-flex justify-content-between align-items-center">
                                                <span>Category <span class="text-danger">*</span></span>
                                            </label>
                                            <select id="select2-1" name="category_id" class="form-select" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="Subcategory" class="form-label mt-3">Subcategory</label>
                                            <select id="select2-2" name="subcategory_id" class="form-select">
                                                <option value="">Select Subcategory</option>
                                            </select>
                                            @error('subcategory_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <!-- Product Name -->
                                        <div class="col-md-12">
                                            <label for="Product" class="form-label mt-3">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="Product" name="product"
                                                value="{{ old('product') }}" required />
                                            @error('product')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-12">
                                            <label for="Status" class="form-label mt-3">ThumbImage <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse</div>
                                                </div>
                                                <div class="form-control file-amount">Choose file</div>
                                                <input type="hidden" name="thumbphotos" class="selected-files"
                                                    value="{{ old('thumbphotos') }}" required>
                                            </div>
                                            <div class="file-preview box sm"></div>
                                            @error('thumbphotos')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-12">
                                            <label for="Status" class="form-label mt-3">Multiple Image </label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="true">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse</div>
                                                </div>
                                                <div class="form-control file-amount">Choose file</div>
                                                <input type="hidden" name="multiple_image" class="selected-files"
                                                    value="{{ old('multiple_image') }}">
                                            </div>
                                            <div class="file-preview box sm"></div>
                                            @error('multiple_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Product Detail</h2>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-md-12">
                                            <label for="short_description" class="form-label mt-3">Short Description <span
                                                    class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                                            @error('short_description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Terms & Conditions -->
                                        <div class="col-md-12">
                                            <label for="terms_conditions" class="form-label mt-3">Terms &
                                                Conditions</label>
                                            <textarea class="form-control" name="terms_conditions" rows="3">{{ old('terms_conditions') }}</textarea>
                                            @error('terms_conditions')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>



                            </div>

                            <div class="col-xl-6">


                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Other</h2>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <!-- status -->
                                            <div class="col-md-6">
                                                <label for="Status" class="form-label mt-3">Status <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select form-control" id="Status" name="status"
                                                    required>
                                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                                        Publish</option>
                                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                        Draft
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- GST -->
                                            <div class="col-md-6">
                                                <label for="GST" class="form-label mt-3">Stock Status <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select form-control" id="in_stock" name="in_stock"
                                                    required>
                                                    <option value="1" {{ old('in_stock') == 1 ? 'selected' : '' }}>
                                                        Available </option>
                                                    <option value="0" {{ old('in_stock') == 0 ? 'selected' : '' }}>
                                                        Out Of Stock </option>
                                                </select>

                                                @error('in_stock')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Product Pricing</h2>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">


                                            <!-- MRP Price -->
                                            <div class="col-md-6">
                                                <label for="MRPPrice" class="form-label">MRP Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="MRPPrice"
                                                    name="mrp_price" step="0.01" value="{{ old('mrp_price') }}"
                                                    required />
                                                @error('mrp_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="purchase" class="form-label ">Our Cost <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="purchase"
                                                    name="purchase_cost" step="0.01"
                                                    value="{{ old('purchase_cost') }}" />
                                                @error('purchase_cost')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="purchase_gst" class="form-label mt-3">Purchase GST <span
                                                        class="text-danger">(%)</span></label>
                                                <input type="number" class="form-control" id="purchase_gst"
                                                    name="purchase_gst" step="0.01" required
                                                    value="{{ old('purchase_gst') }}" />
                                                @error('purchase_gst')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <!-- Discount Price -->
                                            <div class="col-md-6">
                                                <label for="netcost" class="form-label mt-3">Net Cost <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="netcost"
                                                    name="net_cost" step="0.01" value="{{ old('net_cost') }}"
                                                    required />
                                                @error('net_cost')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Discount Price -->
                                            <div class="col-md-6">
                                                <label for="saleprice" class="form-label mt-3">Sale Price (After Discount
                                                    )</label>
                                                <input type="number" class="form-control" id="saleprice"
                                                    name="sale_price" step="0.01" value="{{ old('sale_price') }}"
                                                    required />
                                                @error('sale_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-md-6">
                                                <label for="sale_gst" class="form-label mt-3">Sale GST
                                                    <span class="text-danger">(%)</span></label>
                                                <input type="number" class="form-control" id="sale_gst"
                                                    name="sale_gst" step="0.01" value="{{ old('sale_gst') }}"
                                                    required />

                                                <span id="payable_sale_gst"></span>
                                                @error('sale_gst')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>





                                            <div class="col-md-6">
                                                <label for="payable_gst" class="form-label mt-3">Payable Gst Amount
                                                    <span class="text-danger"> (to Gov) </span>
                                                </label>
                                                <input type="number" class="form-control" readonly id="payable_gst"
                                                    name="payable_gst" step="0.01"
                                                    value="{{ old('payable_gst') }}" />
                                                <span id="payable_purchase_gst"></span>
                                                <br>

                                                @error('payable_gst')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>



                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Meta Details</h2>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">


                                            <!-- Discount Price -->
                                            <div class="col-md-12">
                                                <label for="meta_title" class="form-label mt-3">Meta Title
                                                </label>
                                                <input type="text" class="form-control" id="meta_title"
                                                    name="meta_title" step="0.01" value="{{ old('meta_title') }}" />
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Discount Price -->
                                            <div class="col-md-12">
                                                <label for="meta_keywords" class="form-label mt-3"> Meta Keywords</label>
                                                <textarea name="meta_keywords" class="form-control" id="meta_keywords" cols="4" rows="4">{{ old('meta_keywords') }}</textarea>
                                                @error('meta_keywords')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Discount Price -->
                                            <div class="col-md-12">
                                                <label for="meta_description" class="form-label mt-3">Meta
                                                    Description</label>
                                                <textarea name="meta_description" class="form-control" id="meta_description" cols="4" rows="4">{{ old('meta_description') }}</textarea>

                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success m-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('#select2-1, #select2-2').select2();

        });
    </script>

    <script>
        $(document).ready(function() {
            let taxPurchase = 0; // Declare globally to track purchase GST
            let netCostValue = 0; // Track net cost
            let discountAmount = 0; // Track discount amount

            // Purchase GST and Net Cost Calculation
            $('#purchase_gst, #purchase').on('keyup', function() {
                const gstValue = parseFloat($('#purchase_gst').val());
                const purchase = parseFloat($('#purchase').val());

                if (isNaN(purchase) || purchase <= 0) {
                    $('#netcost').val('');
                    $('#payable_purchase_gst').text('');
                    return;
                }

                netCostValue = purchase + (purchase * gstValue / 100);
                taxPurchase = purchase * gstValue / 100;

                $('#netcost').val(netCostValue.toFixed(2));
                $('#sale_gst').val(gstValue.toFixed(2));
                $('#payable_purchase_gst').text(
                    `Purchase Tax: ₹${(isNaN(taxPurchase) ? 0 : taxPurchase).toFixed(2)}`
                );
            });

            // Sale Price, GST, and Distribution Calculation
            $('#saleprice, #disper, #sale_gst').on('keyup', function() {
                const salePrice = parseFloat($('#saleprice').val());
                const saleGst = parseFloat($('#sale_gst').val());
                const distributePercentage = parseFloat($('#disper').val());

                // Reset fields if inputs are invalid
                if (isNaN(salePrice) || salePrice <= 0) {
                    $('#payable_gst').val('');
                    $('#payable_sale_gst').text('');
                    $('#total_payable').text('');
                    $('#disamount').text('');
                    $('#profit_amount').val('');
                    return;
                }

                // Calculate GST amount
                let gstAmount = 0;
                if (!isNaN(saleGst) && saleGst > 0) {
                    gstAmount = (salePrice * saleGst / 100);
                }

                const payableGst = gstAmount > 0 ? (gstAmount - taxPurchase) : 0;
                const totalPayable = gstAmount > 0 ? (salePrice + gstAmount) : salePrice;

                $('#payable_gst').val(payableGst.toFixed(2));
                $('#payable_sale_gst').text(`GST Amount: ₹${gstAmount.toFixed(2)}`);
                $('#total_payable').text(`Total Payable: ₹${totalPayable.toFixed(2)}`);

                // Calculate and display the "Distribute" value last
                if (!isNaN(distributePercentage) && distributePercentage > 0) {
                    discountAmount = (salePrice * distributePercentage / 100);
                    $('#disamount').text(`Distribute: ₹${discountAmount.toFixed(2)}`);
                } else {
                    discountAmount = 0;
                    $('#disamount').text('');
                }

                // Calculate and display profit
                const profit = salePrice - (payableGst + netCostValue + discountAmount);
                $('#profit_amount').val(profit.toFixed(2));
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('#select2-1, #select2-2').select2();

            // Preselected values from server
            const selectedCategoryId = "{{ old('category_id') }}";
            const selectedSubcategoryId = "{{ old('subcategory_id') }}";

            // If a category is preselected, load the subcategories
            if (selectedCategoryId) {
                loadSubcategories(selectedCategoryId, selectedSubcategoryId);
            }

            // When the category dropdown changes
            $('#select2-1').on('change', function() {
                const categoryId = $(this).val();
                const subcategoryDropdown = $('#select2-2');

                // Reset subcategory dropdown
                subcategoryDropdown.html('<option value="">Select Subcategory</option>').select2();

                if (categoryId) {
                    loadSubcategories(categoryId);
                }
            });

            // Function to load subcategories based on category ID
            function loadSubcategories(categoryId, preselectedSubcategoryId = null) {
                const subcategoryDropdown = $('#select2-2');

                $.ajax({
                    url: `subcategories/${categoryId}`, // Replace with your route
                    type: 'GET',
                    dataType: 'json',
                    success: function(subcategories) {
                        // Populate subcategory dropdown
                        $.each(subcategories, function(index, subcategory) {
                            const isSelected = preselectedSubcategoryId == subcategory.id ?
                                'selected' : '';
                            subcategoryDropdown.append(
                                `<option value="${subcategory.id}" ${isSelected}>${subcategory.category_name}</option>`
                            );
                        });
                        subcategoryDropdown.select2();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading subcategories:', error);
                    }
                });
            }
        });
    </script>

    <link href="{{ asset('panel/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src="{{ asset('panel/js/pages/form-select2.init.js') }}"></script>
    <script src="{{ asset('panel/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('panel/libs/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 2000);
            }
        });
    </script>

    <script>
        if ($("#basic-example").length > 0) {
            tinymce.init({
                selector: 'textarea#basic-example',
                height: 400,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        }
    </script>
@endpush
