@extends('admin.layouts.app')
@section('content')

<div id="layout-wrapper">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Product List</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-products" class="table table-bordered table-striped nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>MRP</th>
                                                <th>Net Cost</th>
                                                <th>Sale Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ Str::limit($product->product_name, 20) }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            {{ $product->category->category_name ?? 'No Category' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $product->mrp_price }}</td>
                                                    <td>{{ $product->net_cost }}</td>
                                                    <td>{{ $product->sale_price }}</td>

                                                    <td>
                                                        <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                            Edit
                                                        </a>

                                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                                data-id="{{ $product->id }}">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> {{-- table-responsive --}}
                            </div> {{-- card-body --}}
                        </div> {{-- card --}}

                    </div>
                </div>

            </div> {{-- container-fluid --}}
        </div>
    </div>

</div>

@endsection

{{-- ✅ DataTables CSS --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush


{{-- ✅ Scripts --}}
@push('scripts')
<script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

<script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(document).ready(function() {

        // ✅ DataTable Init (Prevents Duplicate Initialization Error)
        if (!$.fn.DataTable.isDataTable('#datatable-products')) {
            $('#datatable-products').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
                 searching: true, // Enable search functionality
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-left"></i>', // Previous button
                        next: '<i class="fas fa-angle-right"></i>' // Next button
                    }
                }
            });
        }

        // ✅ Auto-hide alerts
        setTimeout(() => {
            $('#success-alert').alert('close');
        }, 2000);

        // ✅ Delete Confirmation
        $('.delete-btn').click(function () {
            let id = $(this).attr('data-id');

            Swal.fire({
                title: 'Delete Product?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch(`{{ url('admin/product/delete') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).then(() => {
                        Swal.fire('Deleted!', 'Product has been removed.', 'success');
                        setTimeout(() => location.reload(), 800);
                    }).catch(() => {
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    });

                }
            });
        });

    });
</script>
@endpush
