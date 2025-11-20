<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa;">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                        <h4 class="mb-0">User Login</h4>
                    </div>

                    <div class="card-body p-4">

                        {{-- ✅ Display Session Alerts --}}
                        @if (session('error'))
                            <div class="alert alert-danger text-center mb-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-center mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- ✅ Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- ✅ Login Form --}}
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Enter your password" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePassword('password', 'eyeIcon')">
                                        <i id="eyeIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <hr>
                        <div class="text-center">
                            <small>Don’t have an account?
                                <a href="{{ route('user.password.request') }}">Reset Password</a>
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

    {{-- ✅ Toggle Password Visibility --}}
    <script>
        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
