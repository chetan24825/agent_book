@extends('admin.layouts.app')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alerts --}}
                @if ($errors->any() || session('message') || session('error') || session('success'))
                    <div
                        class="alert
                    {{ $errors->any() || session('error') ? 'alert-danger' : (session('success') ? 'alert-success' : 'alert-warning') }}">
                        <ul class="list-group mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                            @if (session('message') || session('error') || session('success'))
                                <li>{{ session('message') ?? (session('error') ?? session('success')) }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                {{-- Add Category --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Categories</h3>
                    </div>

                    <div class="card-body">
                        <form class="row g-3" action="{{ route('admin.categories') }}" method="POST">
                            @csrf

                            {{-- Parent Category --}}
                            <div class="col-md-6">
                                <label class="form-label">Parent Category</label>
                                <select name="parent_id" class="form-select form-control">
                                    <option value="">Main Category</option>
                                    @foreach ($parents as $p)
                                        <option value="{{ $p->id }}">{{ $p->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Category Name --}}
                            <div class="col-md-6">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="category_name"
                                    value="{{ old('category_name') }}">
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select form-control" name="status">
                                    <option value="1">Publish</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>

                            {{-- Image --}}
                            <div class="col-md-6">
                                <label class="form-label">Image</label>
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <span class="input-group-text bg-soft-secondary">Browse</span>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="image" class="selected-files" value="{{ old('image') }}">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- List of Categories --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">List Of Categories</h4>
                    </div>

                    <div class="card-body">
                        <table id="datatable-products"
                            class="table table-bordered table-striped table-hover dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Parent Category</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $category->category_name }}</td>

                                        <td>
                                            @if ($category->parent)
                                                <span class="badge bg-info">{{ $category->parent->category_name }}</span>
                                            @else
                                                <span class="badge bg-secondary">Main</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($category->image)
                                                <img src="{{ uploaded_asset($category->image) }}" width="60"
                                                    class="rounded border">
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge bg-{{ $category->status ? 'success' : 'warning' }}">
                                                {{ $category->status ? 'Publish' : 'Draft' }}
                                            </span>
                                        </td>

                                        <td>
                                            <button class="btn btn-danger btn-sm delete" data-id="{{ $category->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $category->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editModal{{ $category->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Category</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('admin.category.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $category->id }}">

                                                        {{-- Parent --}}
                                                        <label class="form-label mt-2">Parent Category</label>
                                                        <select name="parent_id" class="form-select form-control">
                                                            <option value="">Main Category</option>
                                                            @foreach ($parents as $p)
                                                                <option value="{{ $p->id }}"
                                                                    {{ $category->parent_id == $p->id ? 'selected' : '' }}>
                                                                    {{ $p->category_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        {{-- Name --}}
                                                        <label class="form-label mt-3">Category Name</label>
                                                        <input type="text" name="category_name" class="form-control"
                                                            value="{{ $category->category_name }}">

                                                        {{-- Image --}}
                                                        <label class="form-label mt-3">Image</label>
                                                        <div class="input-group" data-toggle="aizuploader"
                                                            data-type="image">
                                                            <span class="input-group-text bg-soft-secondary">Browse</span>
                                                            <div class="form-control file-amount">Choose File</div>
                                                            <input type="hidden" class="selected-files" name="image"
                                                                value="{{ $category->image }}">
                                                        </div>
                                                        <div class="file-preview box sm"></div>

                                                        {{-- Status --}}
                                                        <label class="form-label mt-3">Status</label>
                                                        <select name="status" class="form-select form-control">
                                                            <option value="1"
                                                                {{ $category->status ? 'selected' : '' }}>Publish</option>
                                                            <option value="0"
                                                                {{ !$category->status ? 'selected' : '' }}>Draft</option>
                                                        </select>

                                                        <div class="modal-footer mt-4">
                                                            <button class="btn btn-primary">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection


{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function() {

            if (!$.fn.DataTable.isDataTable('#datatable-products')) {
                $('#datatable-products').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    searching: true, // Enable search functionality
                    language: {
                        paginate: {
                            previous: '<i class="fas fa-angle-left"></i>', // Previous button
                            next: '<i class="fas fa-angle-right"></i>' // Next button
                        }
                    }
                });
            }

            // Delete handling
            $(document).on("click", ".delete", function() {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('admin/category/delete') }}/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').content
                                }
                            })
                            .then(() => {
                                Swal.fire("Deleted!", "Record removed.", "success")
                                    .then(() => location.reload());
                            });
                    }
                });

            });

        });
    </script>
@endpush
