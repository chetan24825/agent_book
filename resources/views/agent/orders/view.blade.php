@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Items</h5>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price (₹)</th>
                                        <th>Qty</th>
                                        <th>Note</th>
                                        <th>Total (₹)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>

                                                <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                    title="{{ $item->message }}">
                                                    {{ Str::limit($item->message ?? '', 50, '...') }}
                                                </em>
                                            </td>

                                            <td>{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr class="fw-bold table-info">
                                        <td colspan="5" class="text-end">Grand Total:</td>
                                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
