@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-header-bordered">
                        <h3 class="card-title">Profile</h3>
                    </div>
                    <div class="card-body">

                        @if (session()->has('message') || session()->has('error') || session()->has('success'))
                            <div
                                class="alert {{ session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning') }}">
                                {{ session('message') ?? (session('error') ?? session('success')) }}
                            </div>
                        @endif

                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                    role="tab">Profile Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kyc-tab" data-bs-toggle="tab" href="#kycTab" role="tab">
                                    KYC
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="bank-tab" data-bs-toggle="tab" href="#bankTab" role="tab">
                                    Bank Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">
                                    Password Settings
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="adminVerify-tab" data-bs-toggle="tab" href="#adminVerify"
                                    role="tab">
                                    Admin Verify Settings
                                </a>
                            </li>


                        </ul>

                        <div class="tab-content mt-3" id="profileTabsContent">

                            {{-- Profile Tab --}}
                            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                <form action="{{ route('admin.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <input type="hidden" name="id" value="{{ $user->id }}">

                                        <div class="col-md-6">
                                            <label class="form-label">Agent Code</label>
                                            <input type="text" class="form-control" name="agent_code"
                                                value="{{ old('agent_code', $user->agent_code) }}" readonly>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', $user->email) }}">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ old('state', $user->state) }}">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city', $user->city) }}">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Alternate Phone</label>
                                            <input type="text" class="form-control" name="phone_2"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)"
                                                value="{{ old('phone_2', $user->phone_2) }}">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                        </div>

                                        <div class="btn-group btn-group-lg mb-2 mt-4">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- KYC Tab --}}
                            <div class="tab-pane fade" id="kycTab" role="tabpanel">
                                <form class="row g-3" action="{{ route('admin.kyc.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">


                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Pan Card <span class="text-danger">*</span></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image"
                                            data-multiple="false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">Browse
                                                </div>
                                            </div>
                                            <div class="form-control file-amount">Choose file</div>
                                            <input type="hidden" name="pancard" class="selected-files"
                                                value="{{ old('pancard', $user->pancard) }}" required>
                                        </div>
                                        <div class="file-preview box sm"></div>
                                        @error('pancard')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white">
                                            {{ $user->user_pin ? 'Update' : 'Save' }}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Bank Details Tab --}}
                            <div class="tab-pane fade" id="bankTab" role="tabpanel">
                                <form class="row g-3" action="{{ route('admin.bank.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <div class="col-md-6">
                                        <label class="form-label">Account Holder Name</label>
                                        <input type="text" class="form-control" name="account_holder_name"
                                            value="{{ old('account_holder_name', $user->account_name) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name"
                                            value="{{ old('bank_name', $user->bank_name) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" class="form-control" name="account_number"
                                            value="{{ old('account_number', $user->account_number) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Confirm Account Number</label>
                                        <input type="text" class="form-control" name="confirm_account_number"
                                            value="{{ old('confirm_account_number', $user->account_number) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" class="form-control" name="ifsc_code"
                                            value="{{ old('ifsc_code', $user->ifsc_code) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Type</label>
                                        <select class="form-control" name="account_type" required>
                                            <option value="">Select Account Type</option>
                                            <option value="savings"
                                                {{ old('account_type', $user->account_type) == 'savings' ? 'selected' : '' }}>
                                                Savings</option>
                                            <option value="current"
                                                {{ old('account_type', $user->account_type) == 'current' ? 'selected' : '' }}>
                                                Current</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Check Book Image <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image"
                                            data-multiple="false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">Browse
                                                </div>
                                            </div>
                                            <div class="form-control file-amount">Choose file</div>
                                            <input type="hidden" name="check_image" class="selected-files"
                                                value="{{ old('check_image', $user->check_image) }}" required>
                                        </div>
                                        <div class="file-preview box sm"></div>
                                        @error('check_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-white">Save</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Password Tab --}}
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                <form action="{{ route('admin.profile.updatePassword') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">


                                    @php
                                        try {
                                            $decryptedPassword = $user->plain_password
                                                ? Crypt::decryptString($user->plain_password)
                                                : null;
                                        } catch (\Exception $e) {
                                            $decryptedPassword = null;
                                        }
                                    @endphp

                                    @if ($decryptedPassword)
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Current Login Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="currentPassword"
                                                    value="{{ $decryptedPassword }}" readonly>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="togglePassword('currentPassword','ic1')">
                                                    <i id="ic1" class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="newPassword"
                                                required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('newPassword','ic2')">
                                                <i id="ic2" class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                id="confirmPassword" required>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('confirmPassword','ic3')">
                                                <i id="ic3" class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="btn-group btn-group-lg mb-3 mt-4">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>

                                </form>
                            </div>

                            <div class="tab-pane fade" id="adminVerify" role="tabpanel">
                                <form class="row g-3" action="{{ route('admin.agent.verify') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    {{-- ✅ Bank Verification Field --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fw-bold">Bank Verification Password</label>
                                        <div class="input-group">
                                            <select name="admin_verification_status" class="form-select form-control"
                                                required>
                                                <option value="">Select Status</option>
                                                <option value="0"
                                                    {{ $user->admin_verification_status == 0 ? 'selected' : '' }}>
                                                    Not-Verified
                                                </option>

                                                <option value="1"
                                                    {{ $user->admin_verification_status == 1 ? 'selected' : '' }}>
                                                    Verified</option>
                                            </select>
                                        </div>
                                        @error('admin_verification_status')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- ✅ Status Dropdown --}}
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fw-bold">Agent Status</label>
                                        <select name="status" class="form-select form-control" required>
                                            <option value="">Select Status</option>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>In-Active
                                            </option>

                                        </select>
                                    </div>

                                    {{-- ✅ Submit Button --}}
                                    <div class="btn-group btn-group-lg mb-4 mt-4">
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </div>
                                </form>
                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(field, icon) {
            let x = document.getElementById(field);
            let i = document.getElementById(icon);
            x.type = x.type === "password" ? "text" : "password";
            i.classList.toggle("fa-eye");
            i.classList.toggle("fa-eye-slash");
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('active_tab'))
                new bootstrap.Tab(document.querySelector('#{{ session('active_tab') }}-tab')).show();
            @endif
        });
    </script>
@endsection
