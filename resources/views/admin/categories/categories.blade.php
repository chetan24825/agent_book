@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    @if ($errors->any() || session()->has('message') || session()->has('error') || session()->has('success'))
                        <div
                            class="alert {{ $errors->any() ? 'alert-danger' : (session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning')) }}">
                            <ul class="list-group">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif

                                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                                    {{ session('message') ?? (session('error') ?? session('success')) }}
                                @endif
                            </ul>
                        </div>
                    @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header card-header-bordered justify-content-between">
                                <h3 class="card-title">Categories</h3>

                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('admin.categories') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Category Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="category_name"
                                            value="{{ old('category_name') }}" />
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-label" for="inputGroupSelect01">Status</label>

                                        <div class="input-group">
                                            <select class="form-select form-control" name="status" id="inputGroupSelect01">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish
                                                </option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="signinSrEmail">Select The Image </label>

                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="image" value="{{ old('image') }}"
                                                    class="selected-files">
                                            </div>
                                            <div class="file-preview box sm">

                                            </div>

                                            @error('image')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary text-white">Sumbit</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title">List Of Categories</h4>
                            </div>

                            <div class="card-body">
                                <table id="datatable-row-callback"
                                    class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>

                                            <th>Images</th>
                                            <th>Status</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $category)
                                            <tr>

                                                <td>
                                                    {{ $key + 1 }}
                                                </td>

                                                <td>
                                                    {{ $category->category_name }}
                                                </td>

                                                <td>
                                                    @if ($category->image)
                                                        <img src="{{ uploaded_asset($category->image) }}" height="100px"
                                                            width="100px!important" alt="Slider Image" class="rounded">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($category->status == 1)
                                                        <span class="badge bg-success">Publish</span>
                                                    @else
                                                        <span class="badge bg-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">

                                                        <button class="btn btn-danger m-1 delete" id="swal-7"
                                                            data-id="{{ $category->id }}"> <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <button class="btn btn-primary m-1 " data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $category->id }}"><i
                                                                class="fas fa-pencil-alt"></i></button>



                                                        <div class="modal fade" id="modal{{ $category->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Update Category</h5>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-label-danger btn-icon"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="mdi mdi-close"></i>
                                                                        </button>


                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('admin.category.update') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div>
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $category->id }}">
                                                                                <label class="form-label"
                                                                                    for="email">Category Name <span
                                                                                        class="text-danger">*</span>
                                                                                </label>
                                                                                <input type="text" class="form-control"
                                                                                    id="name" name="category_name"
                                                                                    value="{{ old('category_name', $category->category_name) }}" />
                                                                                @error('category_name')
                                                                                    <span
                                                                                        class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror


                                                                                <div class="form-group mt-4">
                                                                                    <label for="signinSrEmail ">Select The
                                                                                        Image </label>

                                                                                    <div class="input-group"
                                                                                        data-toggle="aizuploader"
                                                                                        data-type="image"
                                                                                        data-multiple="false">
                                                                                        <div class="input-group-prepend">
                                                                                            <div
                                                                                                class="input-group-text bg-soft-secondary font-weight-medium">
                                                                                                Browse
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="form-control file-amount">
                                                                                            Choose File</div>
                                                                                        <input type="hidden"
                                                                                            name="image"
                                                                                            value="{{ old('image', $category->image) }}"
                                                                                            class="selected-files">
                                                                                    </div>
                                                                                    <div class="file-preview box sm">

                                                                                    </div>

                                                                                    @error('image')
                                                                                        <span class="text-danger"
                                                                                            role="alert">
                                                                                            <strong>{{ ucwords($message) }}</strong>
                                                                                        </span>
                                                                                    @enderror

                                                                                </div>

                                                                                <label class="form-group-text mt-2"
                                                                                    for="inputGroupSelect01">Status</label>

                                                                                <div class="input-group">
                                                                                    <select
                                                                                        class="form-select form-control"
                                                                                        name="status"
                                                                                        id="inputGroupSelect01">
                                                                                        <option value="1"
                                                                                            {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                                                                                            Publish
                                                                                        </option>
                                                                                        <option value="0"
                                                                                            {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                                                                                            Draft
                                                                                        </option>
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button
                                                                                    class="btn btn-primary">Submit</button>
                                                                                <button
                                                                                    class="btn btn-outline-danger">Reset</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('styles')
    <!-- Include SweetAlert2 CSS properly -->
    <link rel="stylesheet" href="{{ asset('panel/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).on("click", ".delete", function() {
            let itemId = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('admin/category/delete') }}/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    }).then(data => {
                        Swal.fire('Deleted!',
                            ` Record has been deleted.`,
                            'success').then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire('Oops...', 'Something went wrong!',
                            'error');
                    });
                }
            });
        });
    </script>
@endpush
