<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Checkmate</title>
    <!-- Add any CSS libraries you want here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Daily Checkmate</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('todos.index') }}">Todos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reminders.index') }}">Reminders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('habits.index') }}">Habits</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Add any JS libraries you want here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
