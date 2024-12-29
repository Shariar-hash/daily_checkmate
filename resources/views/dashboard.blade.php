<x-app-layout>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   
   <div class="container py-4">
       <!-- Clock -->
       <div class="card mb-4 shadow-sm">
           <div class="card-body text-center py-3">
               <div id="clock" class="display-4 mb-0" style="font-size: 3.5rem; font-weight: 300;"></div>
               <div id="date" class="text-muted"></div>
           </div>
       </div>

       @php
           $taskCount = $recentTasks->count();
           $reminderCount = $upcomingReminders->count();
       @endphp

       <div class="row">
           <!-- Tasks-->
           <div class="col-md-4 mb-4">
               <div class="card h-100 shadow-sm border-0 rounded-3">
                   <div class="card-header bg-primary bg-gradient text-white py-3 rounded-top-3">
                       <h5 class="card-title mb-0 d-flex align-items-center">
                           <i class="fas fa-tasks me-2"></i>
                           Tasks 
                           @if($recentTasks->count() > 0)
                               <span class="badge bg-white text-primary ms-2">{{ $recentTasks->count() }}</span>
                           @endif
                       </h5>
                   </div>
                   <div class="card-body">
                       @if($recentTasks->count() > 0)
                           @foreach($recentTasks as $task)
                               <div class="d-flex align-items-center py-2 border-bottom">
                                   <div class="flex-grow-1">
                                       <h6 class="mb-0">{{ $task->title }}</h6>
                                       <small class="text-muted">
                                           @if($task->due_date)
                                               Due: {{ Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                           @else
                                               No due date
                                           @endif
                                       </small>
                                   </div>
                                   <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                       @csrf
                                       <button type="submit" class="btn btn-sm btn-success rounded-circle">
                                           <i class="fas fa-check"></i>
                                       </button>
                                   </form>
                               </div>
                           @endforeach
                       @else
                           <div class="text-center py-4">
                               <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                               <p class="text-muted">No pending tasks</p>
                               <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">
                                   <i class="fas fa-plus me-1"></i> Add Task
                               </a>
                           </div>
                       @endif
                   </div>
               </div>
           </div>

           <!-- Habits-->
           <div class="col-md-4 mb-4">
               <div class="card h-100 shadow-sm border-0 rounded-3">
                   <div class="card-header bg-success bg-gradient text-white py-3 rounded-top-3">
                       <h5 class="card-title mb-0 d-flex align-items-center">
                           <i class="fas fa-calendar-check me-2"></i>
                           Habits
                       </h5>
                   </div>
                   <div class="card-body">
                       @if($todaysHabits->count() > 0)
                           @foreach($todaysHabits as $habit)
                               <div class="d-flex align-items-center py-2 border-bottom">
                                   <div class="flex-grow-1">
                                       <h6 class="mb-0">{{ $habit->title }}</h6>
                                       <small class="text-muted">
                                           {{ $habit->frequency }} | 🔥 {{ $habit->streak }} days
                                       </small>
                                   </div>
                                   <form action="{{ route('habits.log', $habit) }}" method="POST">
                                       @csrf
                                       <button type="submit" class="btn btn-sm rounded-circle {{ $habit->completed_today ? 'btn-success' : 'btn-outline-success' }}">
                                           <i class="fas {{ $habit->completed_today ? 'fa-check' : 'fa-plus' }}"></i>
                                       </button>
                                   </form>
                               </div>
                           @endforeach
                       @else
                           <div class="text-center py-4">
                               <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                               <p class="text-muted">No habits created</p>
                               <a href="{{ route('habits.create') }}" class="btn btn-success btn-sm">
                                   <i class="fas fa-plus me-1"></i> Add Habit
                               </a>
                           </div>
                       @endif
                   </div>
               </div>
           </div>

           <!-- Reminders-->
           <div class="col-md-4 mb-4">
               <div class="card h-100 shadow-sm border-0 rounded-3">
                   <div class="card-header bg-warning bg-gradient text-dark py-3 rounded-top-3">
                       <h5 class="card-title mb-0 d-flex align-items-center">
                           <i class="fas fa-bell me-2"></i>
                           Reminders
                           @if($upcomingReminders->count() > 0)
                               <span class="badge bg-dark ms-2">{{ $upcomingReminders->count() }}</span>
                           @endif
                       </h5>
                   </div>
                   <div class="card-body">
                       @if($upcomingReminders->count() > 0)
                           @foreach($upcomingReminders as $reminder)
                               <div class="d-flex align-items-center py-2 border-bottom">
                                   <div class="flex-grow-1">
                                       <h6 class="mb-0">{{ $reminder->title }}</h6>
                                       <small class="text-muted">
                                           @if($reminder->reminder_time)
                                               {{ Carbon\Carbon::parse($reminder->reminder_time)->format('M d, Y g:i A') }}
                                           @endif
                                           @if($reminder->description)
                                               <br>{{ $reminder->description }}
                                           @endif
                                       </small>
                                   </div>
                                   <div class="d-flex gap-2">
                                       <form action="{{ route('reminders.snooze', $reminder) }}" method="POST" class="d-inline">
                                           @csrf
                                           <input type="hidden" name="snooze_until" value="{{ Carbon\Carbon::now()->addHour()->format('Y-m-d H:i:s') }}">
                                           <button type="submit" class="btn btn-sm btn-outline-warning rounded-circle" title="Snooze for 1 hour">
                                               <i class="fas fa-clock"></i>
                                           </button>
                                       </form>
                                       <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete reminder">
                                               <i class="fas fa-trash"></i>
                                           </button>
                                       </form>
                                   </div>
                               </div>
                           @endforeach
                       @else
                           <div class="text-center py-4">
                               <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                               <p class="text-muted">No upcoming reminders</p>
                               <a href="{{ route('reminders.create') }}" class="btn btn-warning btn-sm">
                                   <i class="fas fa-plus me-1"></i> Add Reminder
                               </a>
                           </div>
                       @endif
                   </div>
               </div>
           </div>
       </div>

       
       <div class="card mb-4">
           <div class="card-header">
               <h5 class="card-title mb-0">Breathing Exercise</h5>
           </div>
           <div class="card-body text-center">
               <div class="mb-3">
                   <button class="btn btn-primary" onclick="prevExercise()">
                       <i class="fas fa-chevron-left"></i>
                   </button>
                   <span class="mx-3">
                       <h6 id="exercise-title" class="mb-1"></h6>
                       <small id="exercise-description" class="text-muted"></small>
                   </span>
                   <button class="btn btn-primary" onclick="nextExercise()">
                       <i class="fas fa-chevron-right"></i>
                   </button>
               </div>
               <div id="exercise-timer" class="h4 mb-3">0:00</div>
               <div id="breathing-circle" class="breathing-circle">
                   Tap to Start
               </div>
           </div>
       </div>


       
       <div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Weekly Activity</h5>
    </div>
    <div class="card-body">
        <div style="height: 300px;">
            <canvas id="activityChart"></canvas>
        </div>
    </div>
</div>
   </div>


   
   <style>
      .breathing-circle {
           width: 120px;
           height: 120px;
           border-radius: 50%;
           background-color: #0d6efd;
           color: white;
           display: flex;
           align-items: center;
           justify-content: center;
           margin: 0 auto;
           cursor: pointer;
           transition: all 0.3s ease;
       }

       .inhaling {
           transform: scale(1.5);
           background-color: #0dcaf0;
       }

       .exhaling {
           transform: scale(1);
           background-color: #0d6efd;
       }

       .holding {
           background-color: #6c757d;
       }
   </style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
   <script>
       
       function updateClock() {
           const now = new Date();
           document.getElementById('clock').textContent = now.toLocaleTimeString();
           document.getElementById('date').textContent = now.toLocaleDateString('en-US', {
               weekday: 'long',
               year: 'numeric',
               month: 'long',
               day: 'numeric'
           });
       }
       setInterval(updateClock, 1000);
       updateClock();


       
       let timerSeconds = 0;
       let timerInterval = null;
       let isTimerRunning = false;


       function formatTime(seconds) {
           const h = Math.floor(seconds / 3600);
           const m = Math.floor((seconds % 3600) / 60);
           const s = seconds % 60;
           return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
       }


       function startTimer() {
           if (!isTimerRunning) {
               isTimerRunning = true;
               timerInterval = setInterval(() => {
                   timerSeconds++;
                   document.getElementById('timer').textContent = formatTime(timerSeconds);
               }, 1000);
           }
       }


       function pauseTimer() {
           isTimerRunning = false;
           clearInterval(timerInterval);
       }


       function resetTimer() {
           pauseTimer();
           timerSeconds = 0;
           document.getElementById('timer').textContent = formatTime(timerSeconds);
       }


       
       const exercises = [
           {
               title: 'Box Breathing',
               description: 'Inhale (4s), Hold (4s), Exhale (4s), Hold (4s)',
               sequence: ['inhale', 'hold', 'exhale', 'hold'],
               durations: [4, 4, 4, 4]
           },
           {
               title: '4-7-8 Breathing',
               description: 'Inhale (4s), Hold (7s), Exhale (8s)',
               sequence: ['inhale', 'hold', 'exhale'],
               durations: [4, 7, 8]
           },
           {
               title: 'Deep Breathing',
               description: 'Inhale (5s), Exhale (5s)',
               sequence: ['inhale', 'exhale'],
               durations: [5, 5]
           }
       ];


       let currentExercise = 0;
       let isExercising = false;
       let currentStep = 0;
       let exerciseTimer = null;


       function updateExerciseDisplay() {
           document.getElementById('exercise-title').textContent = exercises[currentExercise].title;
           document.getElementById('exercise-description').textContent = exercises[currentExercise].description;
       }


       function nextExercise() {
           stopExercise();
           currentExercise = (currentExercise + 1) % exercises.length;
           updateExerciseDisplay();
       }


       function prevExercise() {
           stopExercise();
           currentExercise = (currentExercise - 1 + exercises.length) % exercises.length;
           updateExerciseDisplay();
       }


       function startExercise() {
           if (isExercising) return;
           isExercising = true;
           currentStep = 0;
           document.getElementById('breathing-circle').textContent = 'Inhale';
           performStep();
       }


       function stopExercise() {
           isExercising = false;
           currentStep = 0;
           clearTimeout(exerciseTimer);
           const circle = document.getElementById('breathing-circle');
           circle.className = 'breathing-circle';
           circle.textContent = 'Tap to Start';
           document.getElementById('exercise-timer').textContent = '0:00';
       }


       function performStep() {
           if (!isExercising) return;


           const exercise = exercises[currentExercise];
           const action = exercise.sequence[currentStep];
           const duration = exercise.durations[currentStep];
           let timeLeft = duration;


           const circle = document.getElementById('breathing-circle');
           circle.className = `breathing-circle ${action}`;
           circle.textContent = action.charAt(0).toUpperCase() + action.slice(1);


           function updateTimer() {
               if (timeLeft > 0) {
                   document.getElementById('exercise-timer').textContent = timeLeft;
                   timeLeft--;
                   exerciseTimer = setTimeout(updateTimer, 1000);
               } else {
                   currentStep = (currentStep + 1) % exercise.sequence.length;
                   if (isExercising) {
                       performStep();
                   }
               }
           }


           updateTimer();
       }


       document.getElementById('breathing-circle').addEventListener('click', () => {
           if (!isExercising) {
               startExercise();
           } else {
               stopExercise();
           }
       });


       
       updateExerciseDisplay();




       document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    const weeklyStats = @json($weeklyStats);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: weeklyStats.map(day => day.date),
            datasets: [
                {
                    label: 'Tasks Completed',
                    data: weeklyStats.map(day => day.tasks),
                    backgroundColor: '#4F46E5',
                    borderRadius: 6
                },
                {
                    label: 'Habits Completed',
                    data: weeklyStats.map(day => day.habits),
                    backgroundColor: '#10B981',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});



   </script>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</x-app-layout>

