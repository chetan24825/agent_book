@extends('user.layouts.app')

@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">List Of Orders </h4>
                                </div>
                                <div class="card-body">


                                    <table id="datatable-row-callback"
                                        class="table table-hover table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Id</th>
                                                <th>Price</th>
                                                <th>Order Status</th>
                                                <th>Delivered</th>
                                                <th>Payment Status</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td>{{ ++$key ?? '' }}</td>

                                                    <td>{{ $order->order_id }}</td>
                                                    <td>{{ $order->main_amount ?? '' }}</td>

                                                    <td>
                                                        @if ($order->status == 'pending')
                                                            <strong class="badge badge-warning">
                                                                Pending
                                                            </strong>
                                                        @elseif ($order->status == 'approved')
                                                            <strong class="badge badge-success">
                                                                Approved
                                                            </strong>
                                                        @elseif ($order->status == 'cancelled')
                                                            <strong class="badge badge-danger">
                                                                Cancelled
                                                            </strong>
                                                        @endif

                                                    </td>


                                                    <td>
                                                        <em class="badge badge-success">
                                                            {{ $order->delivery_by }}
                                                        </em>
                                                    </td>

                                                    <td>
                                                        @if ($order->payment_status == 'unpaid')
                                                            <strong class="badge badge-warning ">
                                                                {{ ucfirst($order->payment_status) }}
                                                            </strong>
                                                        @else
                                                            <strong class="badge badge-success">
                                                                {{ ucfirst($order->payment_status) }}
                                                            </strong>
                                                        @endif

                                                    </td>

                                                    <td>
                                                        <span class="badge badge-dark">
                                                            {{ $order->updated_at->format('d,M Y') }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('user.order.edit', $order->id) }}" target="blank"
                                                            class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('user.order.invoice', $order->id) }}"
                                                            target="blank" class="btn btn-info"><i
                                                                class="fas fa-file-invoice"></i></a>
                                                    </td>


                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
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
