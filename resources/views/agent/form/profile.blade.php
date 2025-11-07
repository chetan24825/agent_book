@extends('agent.layouts.app')
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

                        <!-- Bootstrap Nav Tabs -->
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                    role="tab">Profile Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password"
                                    role="tab">Password Settings</a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="profileTabsContent">

                            <!-- Profile Details Tab -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                <form action="{{ route('agent.profile') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Agent Code</label>
                                            <input type="text"
                                                value="{{ old('agent_code', auth()->user()->agent_code) }}"
                                                name="agent_code" class="form-control" readonly />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', auth()->user()->name) }}" required />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="phone" maxlength="10"
                                                value="{{ old('phone', auth()->user()->phone) }}" />
                                        </div>


                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">State </label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ old('state', auth()->user()->state) }}" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">City </label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city', auth()->user()->city) }}" />
                                        </div>


                                        <div class="col-md-6 mt-2">
                                            <label for="phone_2" class="form-label">Alternate
                                                Phone</label>
                                            <input type="text" class="form-control" id="phone_2" name="phone_2"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                                maxlength="10" value="{{ auth()->user()->phone_2 }}">
                                            @error('phone_2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                        </div>

                                        <div class="btn-group btn-group-lg mb-2 mt-4">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Password Settings Tab -->
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                <form action="{{ route('agent.profile.updatePassword') }}" method="POST">
                                    @csrf

                                    @php
                                        try {
                                            $decryptedPassword = auth()->user()->plain_password
                                                ? Crypt::decryptString(auth()->user()->plain_password)
                                                : null;
                                        } catch (\Exception $e) {
                                            $decryptedPassword = null; // Prevent crashes if decryption fails
                                        }
                                    @endphp
                                    @if ($decryptedPassword)
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label class="form-label">Current Login Password</label>
                                                <div class="input-group">
                                                    <!-- Initially masked password -->
                                                    <input type="password" class="form-control" id="currentnpasswordField"
                                                        value="{{ $decryptedPassword }}" readonly />

                                                    <!-- Toggle Button -->
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('currentnpasswordField', 'togglecurrentnpasswordIcon')">
                                                        <i id="togglecurrentnpasswordIcon" class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">New Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password"
                                                    id="passwordField" placeholder="Enter new password" />

                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="togglePassword('passwordField', 'togglePasswordIcon')">
                                                    <i id="togglePasswordIcon" class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                    id="confirmPasswordField" placeholder="Re-enter new password" />
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="togglePassword('confirmPasswordField', 'toggleConfirmPasswordIcon')">
                                                    <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="btn-group btn-group-lg mb-2 mt-4">
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div> <!-- End of tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Toggle Password Visibility -->
    <script>
        function togglePassword(fieldId, iconId) {
            let passwordField = document.getElementById(fieldId);
            let icon = document.getElementById(iconId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
