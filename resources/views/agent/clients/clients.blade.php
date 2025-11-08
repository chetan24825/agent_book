@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">List Of Favourites</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Table with dynamic data -->
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>State</th>
                                                <th>City</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($favorites as $key => $favorite)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $favorite->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $favorite->user->email ?? 'N/A' }}</td>
                                                    <td>{{ $favorite->user->phone ?? 'N/A' }}</td>
                                                    <td>{{ $favorite->user->state ?? 'N/A' }}</td>
                                                    <td>{{ $favorite->user->city ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    <div class="pagination-wrapper">
                                        {{-- {{ $favorites->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- DataTables Styles -->
    <link href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@push('scripts')
    <!-- DataTables Scripts -->
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#datatable-row-callback').DataTable({
                responsive: true, // Enable responsive behavior
                pageLength: 10, // Set the default page length
                lengthMenu: [10, 25, 50, 100], // Options for number of records per page
                order: [[0, 'asc']], // Default order by first column (index 0)
                searching: true, // Enable search functionality
                language: {
                    paginate: {
                        previous: '<', // Icon for the "Previous" button
                        next: '>' // Icon for the "Next" button
                    }
                }
            });
        });
    </script>

@endpush
