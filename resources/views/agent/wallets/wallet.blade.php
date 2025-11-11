@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Wallet Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                @if (session('success'))
                                    <div class="alert alert-primary">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white">My Wallet & Withdrawal</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Wallet Balance -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Wallet Balance:</h5>
                                        <h3 class="text-success">
                                            <strong>&#8377; {{ number_format(auth()->user()->balance, 2) }}</strong>
                                        </h3>
                                    </div>
                                    <hr>


                                    <!-- <hr> -->
                                    <form action="{{ route('user.withdraw') }}" method="post" class="row g-3" novalidate>
                                        @csrf

                                        <!-- Withdrawal Amount -->
                                        <div class="col-md-6">
                                            <label for="withdrawAmount" class="form-label">Amount</label>
                                            <input type="number" name="amount" id="withdrawAmount" class="form-control"
                                                placeholder="Enter amount" min="50"
                                                max="{{ auth()->user()->balance }}" value="{{ old('amount') }}" required>
                                            @error('amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary text-white">Request
                                                Withdrawal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Transaction History -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title text-white">Withdrawal History</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable-row-callback" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Transaction Id</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                    <th>Status</th>
                                                    <th>Message</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($withdrawal as $key => $withdraw)
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>
                                                            {{ $withdraw->transaction_id }}
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-danger">
                                                                {{ get_setting('symbol') }}{{ $withdraw->amount }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                {{ get_setting('symbol') }}{{ $withdraw->balance_amount }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($withdraw->status == 1)
                                                                <span class="badge badge-success">Approved</span>
                                                            @elseif ($withdraw->status == 0)
                                                                <span class="badge badge-warning">Pending</span>
                                                            @elseif ($withdraw->status == 2)
                                                                <span class="badge badge-danger">Reject</span>
                                                            @else
                                                                <span class="badge badge-secondary">Unknown</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <em data-bs-toggle="tooltip" style="cursor: pointer;"
                                                                title="{{ $withdraw->remark }}">
                                                                {{ Str::limit($withdraw->remark, 20, '...') }}
                                                            </em>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">
                                                                {{ $withdraw->created_at->format('m-D-Y, h:i A') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty

                                                @endforelse
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- Pagination -->
                                    <div class="mt-3">
                                        {{-- {{ $withdrawal->links() }} --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Transaction History -->
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
