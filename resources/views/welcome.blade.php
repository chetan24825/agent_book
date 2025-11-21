<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ uploaded_asset(get_setting('favicon')) }}">
    <style>
        .dropdown-menu {
            z-index: 2000 !important;
            min-width: 12rem !important;
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- NAV / HEADER -->
    <header class="container py-3">
        <nav class="d-flex justify-content-end gap-3">
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                        {{ Auth::user()->name ?? 'Account' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/user/dashboard') }}">Customer Dashboard</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">@csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm">Register</a>
                @endif
            @endauth
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="container d-flex flex-column align-items-center justify-content-center flex-grow-1">

        <h1 class="fw-bold mb-4">Choose Your Login Type</h1>

        <div class="row g-4 w-100 justify-content-center">


            <div class="col-md-12">
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
            </div>


            <!-- Customer -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow text-center p-4 border-0">
                    <div class="display-5 mb-3">👤</div>
                    <h4 class="fw-bold">Customer</h4>
                    <p>Login as Customer</p>
                    <a href="{{ route('login') }}" class="btn btn-primary mt-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success mt-2">Register</a>
                </div>
            </div>

            <!-- Agent -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow text-center p-4 border-0">
                    <div class="display-5 mb-3">🛍️</div>
                    <h4 class="fw-bold">Agents</h4>
                    <p>Login to manage products</p>
                    <a href="{{ route('agent.login') }}" class="btn btn-success mt-2">Login</a>
                    <a href="{{ route('agent.register') }}" class="btn btn-success mt-2">Register</a>

                </div>
            </div>


            {{-- <div class="col-md-4 col-sm-6">
                <div class="card shadow text-center p-4 border-0">
                    <div class="display-5 mb-3">👑</div>
                    <h4 class="fw-bold">Admin</h4>
                    <p>Login as System Admin</p>
                    <a href="{{ route('admin.login') }}" class="btn btn-warning mt-2 text-white">Login</a>
                </div>
            </div> --}}

        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
