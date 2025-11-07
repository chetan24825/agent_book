<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', config('app.name') . ' Admin Login')</title>

    <link rel="stylesheet" href="{{ asset('panel/css/adminlogin.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

    <div class="login-container">

        <h1>Admin Login</h1>
        <p>Welcome back! Please sign in to continue.</p>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    • {{ $error }} <br>
                @endforeach
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif


        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="input-group">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter your email">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password">
            </div>

            <button type="submit" class="btn">Login</button>

        </form>
    </div>

</body>

</html>
