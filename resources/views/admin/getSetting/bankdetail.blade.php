@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                    <div
                        class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                        {{ session('message') ?? (session('error') ?? session('success')) }}
                    </div>
                @endif

                <form action="{{ route('admin.settings') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Bank Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">


                                        <div class="col-6 mb-3">
                                            <label for="bank_holder_name" class="form-label">Account Holder Name</label>
                                            <input type="text" class="form-control" name="account_holder_name"
                                                id="account_holder_name"
                                                value="{{ old('account_holder_name', get_setting('account_holder_name')) }}" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="bank_name" class="form-label">Bank Name</label>
                                            <input type="text" value="{{ old('bank_name', get_setting('bank_name')) }}"
                                                name="bank_name" class="form-control" id="bank_name" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="account_number" class="form-label">Account Number</label>
                                            <input type="text"
                                                value="{{ old('account_number', get_setting('account_number')) }}"
                                                name="account_number" class="form-control" id="account_number" />
                                        </div>

                                        {{-- ⭐ Added Branch Field --}}
                                        <div class="col-6 mb-3">
                                            <label for="bank_branch" class="form-label">Branch</label>
                                            <input type="text" class="form-control" name="bank_branch" id="bank_branch"
                                                value="{{ old('bank_branch', get_setting('bank_branch')) }}" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="ifsc_code" class="form-label">IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code"
                                                value="{{ old('ifsc_code', get_setting('ifsc_code')) }}" />
                                        </div>



                                        <div class="col-6 mb-3">
                                            <label for="upi_id" class="form-label">UPI ID</label>
                                            <input type="text" class="form-control" name="upi_id" id="upi_id"
                                                value="{{ old('upi_id', get_setting('upi_id')) }}" />
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label">UPI Scanner Image</label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose File</div>
                                                <input type="hidden" name="upi_scaner"
                                                    value="{{ old('upi_scaner', get_setting('upi_scaner')) }}"
                                                    class="selected-files">
                                            </div>
                                            <div class="file-preview box sm"></div>
                                        </div>

                                        <div class="col-12 d-flex btn-group btn-group-lg mb-2 mt-2">
                                            <button type="submit" class="btn btn-primary text-white">Update</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header card-header-bordered">
                                    <h3 class="card-title">Security Deposit Set</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12 mb-3">
                                            <label for="security_deposit" class="form-label">Security Deposit Amount</label>

                                            {{-- <input type="text" class="form-control" name="security_deposit"
                                                id="security_deposit" maxlength="8"
                                                value="{{ old('security_deposit', get_setting('security_deposit')) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" /> --}}

                                            <input type="text" class="form-control" name="security_deposit"
                                                id="security_deposit"
                                                value="{{ old('security_deposit', get_setting('security_deposit')) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />


                                        </div>


                                        <div class="col-12 d-flex btn-group btn-group-lg mb-2 mt-2">
                                            <button type="submit" class="btn btn-primary text-white">Update</button>
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
@endsection
