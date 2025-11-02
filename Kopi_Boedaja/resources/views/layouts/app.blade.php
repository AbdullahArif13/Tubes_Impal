<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Aplikasi Saya')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body>

    <nav class="navbar-global">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">NamaAplikasi</a>
            <div class="navbar-links">
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            </div>
        </div>
    </nav>
    <main class="main-content">
        @yield('content')
    </main>
    

    </body>
</html>