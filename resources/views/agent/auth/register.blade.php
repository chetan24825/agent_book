<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — Agent Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ uploaded_asset(get_setting('favicon')) }}">


    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .register-box {
            width: 100%;
            max-width: 450px;
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.18);
            animation: fadeIn .5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-custom {
            background: #ff7e5f;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: .3s;
        }

        .btn-custom:hover {
            background: #e8684d;
        }

        .link-text a {
            font-weight: 600;
            color: #ff7e5f;
            text-decoration: none;
        }

        .alert {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="register-box">

        <h2 class="text-center mb-1 fw-bold">Agent Register</h2>
        <p class="text-center text-muted mb-4">Create your account</p>

        <!-- Flash Messages -->
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    • {{ $error }} <br>
                @endforeach
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('agent.register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-custom w-100 mt-2">Register</button>

            <p class="text-center mt-3 link-text">Already have an account?
                <a href="{{ route('agent.login') }}">Login</a>
            </p>

            <hr>
            <div class="text-center">
                <small>Back to Home ?
                    <a href="{{ route('home') }}">Home</a>
                </small>
            </div>

        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
