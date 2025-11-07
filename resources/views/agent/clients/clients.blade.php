@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">

                                    <h4 class="card-title"> Client</h4>
                                    <a href="{{ url()->current() }}?export=1" class="btn btn-dark"> <i class="fas fa-download"></i> Download</a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Store Name</th>
                                                <th>Mobile No</th>
                                                <th>Create Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clients as $index => $client)
                                                <tr>
                                                    {{-- <td>{{ ($clients->currentPage() - 1) * $clients->perPage() + $index + 1 }}
                                                    </td> --}}
                                                    <td>{{ ++$index }}</td>
                                                    <td>
                                                        {{ $client->name }}
                                                    </td>

                                                    <td>
                                                        @if (isset($client->store->store_name))
                                                            {{ Str::words($client->store->store_name, 4, '...') }}
                                                        @endif
                                                    </td>
<td>
    {{ $client->phone }}
</td>
                                                    <td>
                                                        <span class="badge bg-warning">
                                                            @if (isset($client->store))
                                                                {{ $client->store->created_at->format('d M, Y') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </span>
                                                    </td>



                                                    <td>
                                                        @if ($client->status == 1)
                                                            <span class="badge bg-success">
                                                                Active
                                                            </span>
                                                        @endif
                                                        @if ($client->status == 0)
                                                            <span class="badge bg-danger">
                                                                In-Active
                                                            </span>
                                                        @endif
                                                    </td>

                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{-- {{ $clients->links('pagination::bootstrap-5') }} --}}
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

@push('styles')
    <link href="{{ asset('panel/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('panel/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush


@push('scripts')
    <script src="{{ asset('panel/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('panel/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('panel/js/pages/datatables-advanced.init.js') }}"></script>
@endpush
