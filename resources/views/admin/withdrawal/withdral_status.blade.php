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
                    <form class="row g-3" action="{{ route('admin.withdrawal.update', $withdrawal->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h2 class="card-title text-white">Agent Detail</h2>
                                    </div>

                                    <div class="card-body">

                                        <!--Name -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label mt-3">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $withdrawal->user->name ?? '') }}" required />
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>





                                            <div class="col-md-6">
                                                <label for="user_balance" class="form-label mt-3">Current Balance <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="user_balance"
                                                    name="user_name"
                                                    value="{{ old('user_balance', $withdrawal->user->commission ?? '') }}"
                                                    required readonly />
                                                @error('user_balance')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>



                                            <div class="col-md-6">
                                                <label for="transaction_id" class="form-label mt-3">Transaction Id <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="transaction_id"
                                                    name="user_name"
                                                    value="{{ old('transaction_id', $withdrawal->transaction_id ?? '') }}"
                                                    required />
                                                @error('transaction_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label mt-3">Status</label>
                                                    <select name="status" class="form-control" disabled>
                                                        <option
                                                            value="0"{{ $withdrawal->status == 0 ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option
                                                            value="1"{{ $withdrawal->status == 1 ? 'selected' : '' }}>
                                                            Delivered</option>

                                                        <option
                                                            value="2"{{ $withdrawal->status == 2 ? 'selected' : '' }}>
                                                            Reject</option>

                                                    </select>
                                                    @error('status')
                                                        <span class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inputName" class="form-label mt-3">Amount Request</label>
                                                    <input type="text" id="inputName" name="request_amount"
                                                        class="form-control" value="{{ $withdrawal->amount }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="inputName">Admin Message</label>
                                                    <textarea name="remark" class="form-control" cols="5" rows="5"
                                                        {{ $withdrawal->status != 0 ? 'readonly' : '' }}>{{ $withdrawal->remark }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if ($withdrawal->status == 0)
                                                <div class="col-md-6">
                                                    <input type="submit" name="reject" value="REJECT"
                                                        class="btn btn-danger float-left">
                                                </div>



                                                <div class="col-md-6 d-flex flex-row-reverse">
                                                    <input type="submit" name="approve" value="APPROVE"
                                                        class="btn btn-success">
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Bank Account Details</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <label for="account_holder_name" class="form-label mt-2">Account
                                                    Holder Name</label>
                                                <input type="text" class="form-control" id="account_holder_name"
                                                    value="{{ old('account_holder_name', $withdrawal->user?->account_name) }}"
                                                    name="account_holder_name" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="bank_name" class="form-label mt-2">Bank
                                                    Name</label>
                                                <input type="text" class="form-control" id="bank_name"
                                                    value="{{ old('bank_name', $withdrawal->user?->bank_name) }}"
                                                    name="bank_name" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="account_number" class="form-label mt-2">Account
                                                    Number</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('account_number', $withdrawal->user?->account_number) }}"
                                                    id="account_number" name="account_number" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="confirm_account_number" class="form-label mt-2">Confirm
                                                    Account
                                                    Number</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('account_holder_name', $withdrawal->user?->account_number) }}"
                                                    id="confirm_account_number" name="confirm_account_number" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="ifsc_code" class="form-label mt-2">IFSC
                                                    Code</label>
                                                <input type="text" class="form-control" id="ifsc_code"
                                                    value="{{ old('ifsc_code', $withdrawal->user?->ifsc_code) }}"
                                                    name="ifsc_code" readonly />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="account_type" class="form-label mt-2">Account
                                                    Type</label>
                                                <select class="form-control" id="account_type" name="account_type"
                                                    readonly>
                                                    <option value="">Select Account Type</option>
                                                    <option value="savings"
                                                        {{ old('account_type', $withdrawal->user?->account_type ?? '') == 'savings' ? 'selected' : '' }}>
                                                        Savings
                                                    </option>
                                                    <option value="current"
                                                        {{ old('account_type', $withdrawal->user?->account_type ?? '') == 'current' ? 'selected' : '' }}>
                                                        Current
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
