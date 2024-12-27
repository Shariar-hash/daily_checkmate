<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Recent Tasks</h2>
    @forelse($recentTasks as $task)
        <div class="mb-3">
            <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">
                {{ $task->title }}
            </a>
            <p class="text-sm text-gray-500">{{ $task->description }}</p>
        </div>
    @empty
        <p class="text-gray-500">No tasks yet</p>
    @endforelse
    <a href="{{ route('tasks.index') }}" class="text-sm text-blue-600 hover:underline">View all tasks</a>
</div>


      
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Today's Habits</h2>
    @forelse($todaysHabits as $habit)
        <div class="mb-3 flex items-center justify-between">
            <span>{{ $habit->title }}</span>
            <form action="{{ route('habits.log', $habit) }}" method="POST">
                @csrf
                <button type="submit" class="text-sm bg-blue-500 text-white px-3 py-1 rounded">
                    Complete
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">No habits scheduled for today</p>
    @endforelse
    <a href="{{ route('habits.index') }}" class="text-sm text-blue-600 hover:underline">Manage habits</a>
</div>

<div class="lg:col-span-3 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Weekly Activity</h2>
            <div class="h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Upcoming Reminders</h2>
    @forelse($upcomingReminders as $reminder)
        <div class="mb-3">
            <p class="font-medium">{{ $reminder->title }}</p>
            @if($reminder->due_at)
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reminder->due_at)->format('M d, Y H:i') }}</p>
            @else
                <p class="text-sm text-gray-500">No due date</p>
            @endif
        </div>
    @empty
        <p class="text-gray-500">No upcoming reminders</p>
    @endforelse
    <a href="{{ route('reminders.index') }}" class="text-sm text-blue-600 hover:underline">View all reminders</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the stats data from PHP
        const stats = @json($weeklyStats);
        
        // Prepare data for Chart.js
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: stats.map(day => day.date),
                datasets: [{
                    label: 'Tasks Completed',
                    data: stats.map(day => day.tasks),
                    backgroundColor: '#4F46E5',
                }, {
                    label: 'Habits Completed',
                    data: stats.map(day => day.habits),
                    backgroundColor: '#10B981',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
