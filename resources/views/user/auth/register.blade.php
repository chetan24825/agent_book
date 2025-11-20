<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa;">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                        <h4 class="mb-0">User Register</h4>
                    </div>

                    <div class="card-body p-4">

                        {{-- Session Alerts --}}
                        @if (session('error'))
                            <div class="alert alert-danger text-center mb-3">{{ session('error') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-center mb-3">{{ session('success') }}</div>
                        @endif

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Register Form --}}
                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf

                            {{-- Sponsor ID --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sponsor ID</label>
                                <input type="text" class="form-control @error('sponsor_id') is-invalid @enderror"
                                    id="sponsor_id" name="sponsor_id" value="{{ old('sponsor_id') }}"
                                    placeholder="Enter Sponsor ID" required>
                                <div id="sponsorStatus" class="mt-1"></div>
                                @error('sponsor_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" placeholder="Enter phone number"
                                    required>
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter password" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('password','eyeIcon')">
                                        <i id="eyeIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirm Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Confirm password" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" id="registerBtn" class="btn btn-primary w-100" disabled>
                                Register
                            </button>
                        </form>


                        <hr>
                        <div class="text-center">
                            <small>Already have an account?
                                <a href="{{ route('login') }}">Login</a>
                            </small>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small>Back to Home ?
                                <a href="{{ route('home') }}">Home</a>
                            </small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            function validateSponsor(sponsorID) {
                if (sponsorID.length < 3) {
                    $("#sponsorStatus").html('');
                    $("#registerBtn").prop("disabled", true);
                    return;
                }

                $.ajax({
                    url: "{{ route('check.sponsor') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        sponsor_id: sponsorID
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $("#sponsorStatus").html(
                                `<span class='text-success fw-bold'><i class='fa fa-check'></i> Valid Sponsor : ${response.name}</span>`
                            );
                            $("#registerBtn").prop("disabled", false);
                        } else {
                            $("#sponsorStatus").html(
                                `<span class='text-danger fw-bold'><i class='fa fa-times'></i> Invalid Sponsor ID</span>`
                            );
                            $("#registerBtn").prop("disabled", true);
                        }
                    }
                });
            }

            // On typing
            $("#sponsor_id").on("keyup", function() {
                validateSponsor($(this).val().trim());
            });

            // Auto check when old value exists after validation failure
            let oldSponsor = "{{ old('sponsor_id') }}";
            if (oldSponsor !== "") {
                validateSponsor(oldSponsor);
            }

        });
    </script>
</body>

</html>
