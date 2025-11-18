@extends('admin.layouts.app')

@section('content')
    @push('styles')
        <style>
            .nav-item.nav-link.active {
                background-color: #000000 !important;
                color: #fff !important;
                border-radius: 5px;
                border: none !important;
                margin-bottom: 10px;
            }
        </style>
    @endpush
    <div id="layout-wrapper">
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            @if (session('success'))
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header card-header-bordered bg-primary">
                                    <div class="card-addon me-auto ms-0">
                                        <div class="nav nav-lines card-nav" id="card7-tab" role="tablist">
                                            <a class="nav-item nav-link text-white active" id="card7-home-tab"
                                                data-bs-toggle="tab" href="#card7-home" aria-selected="true"
                                                role="tab">Profile</a>
                                            <a class="nav-item nav-link text-white" id="card7-password-tab"
                                                data-bs-toggle="tab" href="#card7-password" aria-selected="false"
                                                tabindex="-1" role="tab">Change
                                                Password</a>
                                            <a class="nav-item nav-link text-white" id="card7-profile-tab"
                                                data-bs-toggle="tab" href="#card7-profile" aria-selected="false"
                                                tabindex="-1" role="tab">KYC</a>
                                            <a class="nav-item nav-link text-white" id="card7-contact-tab"
                                                data-bs-toggle="tab" href="#card7-contact" aria-selected="false"
                                                tabindex="-1" role="tab">Bank
                                                Details</a>

                                            <a class="nav-item nav-link text-white" id="adminVerify-tab"
                                                data-bs-toggle="tab" href="#adminVerify" aria-selected="false"
                                                tabindex="-1" role="tab">Admin Verify Settings</a>



                                        </div>
                                    </div>
                                </div>



                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="card7-home" role="tabpanel"
                                            aria-labelledby="card7-home-tab">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title text-dark mb-0">Profile Details</h5>
                                                    <button type="button" class="btn btn-primary btn-sm text-white"
                                                        data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </button>
                                                </div>
                                                <hr>
                                                <!-- Profile Information Display in Two Columns -->
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Shop Name</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->shop_name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Full Name</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->name }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>


                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Email</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->email }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Phone</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->phone }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Alternate Phone</p>

                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">
                                                                    {{ $profile->phone_2 }}</p>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">State</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->state }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">City</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->city }}</p>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Address</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $profile->address }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="card7-password" role="tabpanel"
                                            aria-labelledby="card7-password-tab">
                                            <div class="card-body">
                                                <form action="{{ route('admin.password.update') }}" method="POST">
                                                    @csrf
                                                    <div class="row">

                                                        <input type="hidden" name="id"
                                                            value="{{ $profile->id }}">

                                                        <div class="col-md-6 mb-3">
                                                            <label for="new_password" class="form-label">New
                                                                Password</label>
                                                            <input type="password" class="form-control" id="new_password"
                                                                name="new_password" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="new_password_confirmation"
                                                                class="form-label">Confirm New
                                                                Password</label>
                                                            <input type="password" class="form-control"
                                                                id="new_password_confirmation"
                                                                name="new_password_confirmation" required>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary text-white">Update
                                                        Password</button>
                                                </form>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="card7-profile" role="tabpanel"
                                            aria-labelledby="card7-profile-tab">
                                            <div class="col-xl-12" id="offerProductForm">

                                                <form class="row g-3" action="{{ route('admin.kyc.update') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $profile->id }}">
                                                    <!-- Aadhar Fields -->
                                                    <div class="col-md-6">
                                                        <label for="Status" class="form-label mt-3">PanCard
                                                            <span class="text-danger">*</span></label>
                                                        <div class="input-group" data-toggle="aizuploader"
                                                            data-type="image" data-multiple="false">
                                                            <div class="input-group-prepend">
                                                                <div
                                                                    class="input-group-text bg-soft-secondary font-weight-medium">
                                                                    Browse</div>
                                                            </div>
                                                            <div class="form-control file-amount">Choose file</div>
                                                            <input type="hidden" name="pancard" class="selected-files"
                                                                value="{{ old('pancard', $profile->pancard) }}" required>
                                                        </div>
                                                        <div class="file-preview box sm"></div>
                                                        @error('pancard')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>



                                                    <!-- Submit Button -->
                                                    <div class="col-12">
                                                        <button type="submit" name="save"
                                                            class="btn btn-primary text-white">
                                                            {{ $profile->user_pin === null ? 'Save' : 'Update' }}
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="card7-contact" role="tabpanel"
                                            aria-labelledby="card7-contact-tab">
                                            <div class="col-xl-12" id="offerProductForm">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <form class="row g-3" action="{{ route('admin.bank.update') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf

                                                            <input type="hidden" name="id"
                                                                value="{{ $profile->id }}">

                                                            <div class="col-md-6">
                                                                <label for="account_holder_name"
                                                                    class="form-label">Account
                                                                    Holder Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="account_holder_name"
                                                                    value="{{ old('account_holder_name', $profile->account_name) }}"
                                                                    name="account_holder_name" required />
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="bank_name" class="form-label">Bank
                                                                    Name</label>
                                                                <input type="text" class="form-control" id="bank_name"
                                                                    value="{{ old('bank_name', $profile->bank_name) }}"
                                                                    name="bank_name" required />
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="account_number" class="form-label">Account
                                                                    Number</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('account_number', $profile->account_number) }}"
                                                                    id="account_number" name="account_number" required />
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="confirm_account_number"
                                                                    class="form-label">Confirm Account Number</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('account_holder_name', $profile->account_number) }}"
                                                                    id="confirm_account_number"
                                                                    name="confirm_account_number" required />
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="ifsc_code" class="form-label">IFSC
                                                                    Code</label>
                                                                <input type="text" class="form-control" id="ifsc_code"
                                                                    value="{{ old('ifsc_code', $profile->ifsc_code) }}"
                                                                    name="ifsc_code" required />
                                                            </div>



                                                            <div class="col-md-6">
                                                                <label for="account_type" class="form-label">Account
                                                                    Type</label>
                                                                <select class="form-control" id="account_type"
                                                                    name="account_type" required>
                                                                    <option value="">Select Account Type</option>
                                                                    <option value="savings"
                                                                        {{ old('account_type', $profile->account_type ?? '') == 'savings' ? 'selected' : '' }}>
                                                                        Savings
                                                                    </option>
                                                                    <option value="current"
                                                                        {{ old('account_type', $profile->account_type ?? '') == 'current' ? 'selected' : '' }}>
                                                                        Current
                                                                    </option>
                                                                </select>

                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="gst_number" class="form-label">GST
                                                                    Number</label>
                                                                <input type="text" class="form-control"
                                                                    id="gst_number"
                                                                    value="{{ old('gst_number', $profile->gst_number) }}"
                                                                    name="gst_number" required />
                                                            </div>



                                                            <div class="col-md-6">
                                                                <label for="Status" class="form-label mt-3">Check Book
                                                                    Image
                                                                    <span class="text-danger">*</span></label>
                                                                <div class="input-group" data-toggle="aizuploader"
                                                                    data-type="image" data-multiple="false">
                                                                    <div class="input-group-prepend">
                                                                        <div
                                                                            class="input-group-text bg-soft-secondary font-weight-medium">
                                                                            Browse</div>
                                                                    </div>
                                                                    <div class="form-control file-amount">Choose file</div>
                                                                    <input type="hidden" name="check_image"
                                                                        class="selected-files"
                                                                        value="{{ old('check_image', $profile->check_image) }}"
                                                                        required>
                                                                </div>
                                                                <div class="file-preview box sm"></div>
                                                                @error('check_image')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>




                                                            <div class="col-12">
                                                                <button type="submit" name="save"
                                                                    class="btn btn-primary text-white">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="tab-pane fade" id="card7-crypto" role="tabpanel"
                                            aria-labelledby="card7-crypto-tab">
                                            <div class="card-body">
                                                <form action="#" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="cryptoaddress" class="form-label">Crypto
                                                            Address</label>
                                                        <input type="text" class="form-control" id="cryptoaddress"
                                                            name="cryptoaddress" placeholder="Enter your crypto address"
                                                            required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary text-white">Save
                                                    </button>
                                                </form>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="adminVerify"
                                            aria-labelledby="card7-adminVerify-tab" role="tabpanel">
                                            <form class="row g-3" action="{{ route('admin.user.verify') }}"
                                                method="POST">
                                                @csrf

                                                <input type="hidden" name="id" value="{{ $profile->id }}">

                                                {{-- ✅ Bank Verification Field --}}
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label fw-bold">Bank Verification Password</label>
                                                    <div class="input-group">
                                                        <select name="admin_verification_status"
                                                            class="form-select form-control" required>
                                                            <option value="">Select Status</option>
                                                            <option value="0"
                                                                {{ $profile->admin_verification_status == 0 ? 'selected' : '' }}>
                                                                Not-Verified
                                                            </option>

                                                            <option value="1"
                                                                {{ $profile->admin_verification_status == 1 ? 'selected' : '' }}>
                                                                Verified</option>
                                                        </select>
                                                    </div>
                                                    @error('admin_verification_status')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- ✅ Status Dropdown --}}
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label fw-bold"> Status</label>
                                                    <select name="status" class="form-select form-control" required>
                                                        <option value="">Select Status</option>
                                                        <option value="1"
                                                            {{ $profile->status == 1 ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="0"
                                                            {{ $profile->status == 0 ? 'selected' : '' }}>
                                                            Banned
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
                <!-- end row -->
            </div>
        </div>
    </div>
    </div>
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ Route('admin.profileupdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Profile Image Section -->
                            <div class="col-12 mb-3 ">
                                <label for="Profile" class="form-label">Profile Image</label>

                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="image" value="{{ old('image', $profile->avatar) }}"
                                        class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>

                            <input type="hidden" name="id" value="{{ $profile->id }}">

                            <!-- Other Profile Fields -->
                            @foreach (['shop_name' => 'Shop Name', 'name' => 'Full Name', 'email' => 'Email', 'phone' => 'Phone', 'phone_2' => 'Alternate Phone', 'state' => 'State', 'city' => 'City', 'address' => 'Address'] as $field => $label)
                                <div class="col-md-6 mb-3">
                                    <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                    <input type="text" class="form-control" id="{{ $field }}"
                                        name="{{ $field }}" value="{{ $profile->$field }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary text-white">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (session('active_tab'))
                    var tabTriggerEl = document.querySelector('#{{ session('active_tab') }}-tab');
                    var tab = new bootstrap.Tab(tabTriggerEl);
                    tab.show();
                @endif
            });
        </script>


        <script>
            function previewImage(event) {
                const image = document.getElementById('currentImage');
                image.src = URL.createObjectURL(event.target.files[0]);
                image.style.display = 'block';
            }
        </script>
        <script>
            function previewImage(event, previewId) {
                const image = document.getElementById(previewId);
                image.src = URL.createObjectURL(event.target.files[0]);
                image.style.display = 'block';
            }
        </script>
        <script>
            function toggleKycFields(type) {
                document.getElementById('aadharFields').style.display = 'none';
                document.getElementById('panFields').style.display = 'none';
                document.getElementById('govIdFields').style.display = 'none';
                if (type === 'aadhar') {
                    document.getElementById('aadharFields').style.display = 'block';
                } else if (type === 'pan') {
                    document.getElementById('panFields').style.display = 'block';
                } else if (type === 'gov_id') {
                    document.getElementById('govIdFields').style.display = 'block';
                }
            }
        </script>
    @endpush



@endsection
