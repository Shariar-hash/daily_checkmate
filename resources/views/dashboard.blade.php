<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DailyCheckmate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .navbar {
            background-color: #1e1e1e;
            border-bottom: 1px solid #333;
        }

        body.dark-mode .navbar-brand {
            color: #ffffff !important;
        }

        body.dark-mode .nav-link {
            background-color: #2c2c2c;
            color: #e0e0e0 !important;
            border-color: #444;
        }

        body.dark-mode .nav-link:hover {
            background-color: #444 !important;
            color: #ffffff !important;
            border-color: #555;
        }

        body.dark-mode .widget {
            background-color: #1f1f1f;
            color: #e0e0e0;
            border: 1px solid #333;
        }

        body.dark-mode .calendar {
            background-color: #1f1f1f;
            color: #e0e0e0;
            border: 1px solid #333;
        }

        body.dark-mode #clock {
            background: linear-gradient(135deg, #4b79a1, #283e51);
            color: #ffffff;
        }

        body.dark-mode .quote-widget {
            background-color: #2a2a2a;
            color: #ffffff;
        }

        /* Navbar Styling */
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }

        .nav-link {
            border: 2px solid #dcdcdc;
            border-radius: 5px;
            background-color: #ffffff;
            color: #333;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .nav-link:hover {
            background-color: #007bff !important;
            color: white !important;
            border-color: #0056b3;
        }

        .signout-link {
            border: 2px solid #dcdcdc;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .signout-link:hover {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .profile-link:hover {
            background-color: #28a745 !important;
            color: white !important;
        }

        /* Clock Styling */
        #clock {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }

        /* Widgets */
        .widget {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .todo-list-widget, .habits-reminders-widget {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Quotes Section Styling */
        .quote-widget {
            background-color: rgb(107, 123, 132);
            color: #ffffff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(52, 45, 50, 0.2);
            font-size: 1.1rem;
            font-style: italic;
        }

        /* Calendar */
        .calendar {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
        }

        .quote-section {
            width: 100%;
            padding: 15px 10px;
            margin-top: 20px;
        }

        .list-group-item {
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">DailyCheckmate</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('todo-lists.index') }}">Todo Lists</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('habits.index') }}">Habits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reminders.index') }}">Reminders</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link dark-mode-toggle">🌙</span>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link profile-link" href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link signout-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Recent Todo Lists -->
            <div class="col-md-8">
                <div class="todo-list-widget">
                    <h5>Recent Todo Lists</h5>
                    @if($recentTodoLists->isEmpty())
                        <p>No recent todo lists.</p>
                    @else
                        <div class="list-group">
                            @foreach($recentTodoLists as $todoList)
                                <a href="{{ route('todo-lists.show', $todoList) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $todoList->title }}</h6>
                                        <small>{{ $todoList->tasks_count }} tasks</small>
                                    </div>
                                    <p class="mb-1">{{ $todoList->description ?? 'No description' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Time and Calendar Widgets -->
            <div class="col-md-4">
                <div class="widget">
                    <h5>Current Time</h5>
                    <div id="clock">--:--:-- AM</div>
                </div>
                <div class="widget calendar">
                    <h5>Calendar</h5>
                    <div id="calendar-container"></div>
                </div>
            </div>
        </div>

        <!-- Habits and Reminders Section -->
        <div class="row mt-4">
            <!-- Habits Widget -->
            <div class="col-md-6">
                <div class="habits-reminders-widget">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>My Habits</h5>
                        <a href="{{ route('habits.create') }}" class="btn btn-primary btn-sm">Add Habit</a>
                    </div>
                    @if($habits->isEmpty())
                        <p>No habits created yet. <a href="{{ route('habits.index') }}">Create a habit</a></p>
                    @else
                        <div class="list-group">
                            @foreach($habits as $habit)
                                <a href="{{ route('habits.show', $habit->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $habit->title }}</h6>
                                        <small>{{ ucfirst($habit->frequency) }}</small>
                                    </div>
                                    <p class="mb-1">{{ $habit->description ?? 'No description' }}</p>
                                    <small>Streak: {{ $habit->streak ?? 0 }}</small>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reminders Widget -->
            <div class="col-md-6">
                <div class="habits-reminders-widget">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>My Reminders</h5>
                        <a href="{{ route('reminders.create') }}" class="btn btn-primary btn-sm">Add Reminder</a>
                    </div>
                    @if($reminders->isEmpty())
                        <p>No reminders created yet. <a href="{{ route('reminders.index') }}">Create a reminder</a></p>
                    @else
                        <div class="list-group">
                            @foreach($reminders as $reminder)
                                <a href="{{ route('reminders.index') }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $reminder->title }}</h6>
                                        <small>{{ $reminder->reminder_time->format('M d, Y H:i A') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $reminder->description ?? 'No description' }}</p>
                                    @if($reminder->is_snoozed)
                                        <small class="text-warning">Snoozed until {{ $reminder->snoozed_until?->format('M d, Y H:i A') }}</small>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <div class="quote-section">
        <div class="widget quote-widget text-center">
            <h5>Quote of the Day</h5>
            <p id="quote">Loading...</p>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        const darkModeToggle = document.querySelector(".dark-mode-toggle");
        const body = document.body;

        darkModeToggle.addEventListener("click", () => {
            body.classList.toggle("dark-mode");
            darkModeToggle.textContent = body.classList.contains("dark-mode") ? "☀️" : "🌙";
        });

        function updateClock() {
            const clockElement = document.getElementById("clock");
            setInterval(() => {
                const now = new Date();
                clockElement.textContent = now.toLocaleTimeString('en-US', { hour12: true });
            }, 1000);
        }
        updateClock();

        function generateCalendar() {
            const container = document.getElementById("calendar-container");
            const today = new Date();
            const calendar = document.createElement("input");
            calendar.type = "date";
            calendar.valueAsDate = today;
            calendar.style.width = "100%";
            container.appendChild(calendar);
        }
        generateCalendar();

        function fetchQuote() {
            const quoteElement = document.getElementById("quote");
            fetch('/fetch-quote')
                .then(response => response.json())
                .then(data => {
                    if (data.content) {
                        quoteElement.innerHTML = `"${data.content}"<br><strong>- ${data.author}</strong>`;
                    } else {
                        quoteElement.innerHTML = "Failed to load quote.";
                    }
                })
                .catch(error => {
                    quoteElement.innerHTML = "Failed to load quote.";
                });
        }
        fetchQuote();
    </script>
</body>
</html>