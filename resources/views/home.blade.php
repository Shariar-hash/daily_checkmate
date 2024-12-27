<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Checkmate</title>
    <!-- Link to the Home Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <header>
        <nav>
            <!-- Logo -->
            <div class="logo">
                Dailycheckmate
            </div>
            <!-- Navigation Links -->
            <div class="nav-links">
                <div class="menu">
                    <a href="{{ route('login') }}">Login</a>
                </div>
                <div class="Signup">
                    <a href="{{ route('register') }}">Signup</a>
                </div>
            </div>
        </nav>
        <!-- Hero Text Section -->
        <section class="htxt">
            <span>Dailycheckmate</span>
            <h1>The Best Routine Manager</h1>
            <br>
            <!-- Call to Action Button -->
            <a href="{{ route('login') }}">Create your routine now!</a>
        </section>
    </header>
</body>