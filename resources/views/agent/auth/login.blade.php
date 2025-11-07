<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', config('app.name') . ' Agent Login')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('panel/css/login.css') }}">

</head>

<body>

    <div class="login-box">

        <h1>Agent Login</h1>
        <h2>Welcome back! Please sign in to continue.</h2>

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

        <form method="POST" action="{{ route('agent.login') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
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
