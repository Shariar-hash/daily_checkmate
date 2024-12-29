<?php
use App\Http\Controllers\{
   TodoListController,
   TaskController,
   ReminderController,
   HabitController,
   IdeaController,
   WeeklyReflectionController,
   DashboardController,
   ProfileController,
   BreakController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FullCalenderController;


Route::get('fullcalender', [FullCalenderController::class, 'index']);
Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);
Route::resource('fullcalender', FullCalenderController::class);


Route::get('/', function () {
   return view('welcome');
})->name('welcome');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
  
Route::get('/reminders/create', [ReminderController::class, 'create'])->name('reminders.create');

    Route::resource('tasks', TaskController::class);
    Route::resource('reminders', ReminderController::class);
    Route::post('tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
    Route::post('reminders/{reminder}/snooze', [ReminderController::class, 'snooze'])->name('reminders.snooze');
    
    Route::resource('reminders', ReminderController::class);
    Route::resource('habits', HabitController::class);
    Route::get('/breaks', [BreakController::class, 'index'])->name('breaks.index');
    Route::resource('tasks', TaskController::class);
   
   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   Route::get('/todo-lists/archived', [TodoListController::class, 'archived'])->name('todo-lists.archived');
   Route::post('/todo-lists/{todoList}/archive', [TodoListController::class, 'archive'])->name('todo-lists.archive');
   Route::post('/todo-lists/{todoList}/restore', [TodoListController::class, 'restore'])->name('todo-lists.restore');
   Route::resource('todo-lists', TodoListController::class);
   Route::post('/todo-lists/{todoList}/tasks', [TaskController::class, 'store'])->name('tasks.store');
   Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
   Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
   Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
   Route::post('/reminders/{reminder}/snooze', [ReminderController::class, 'snooze'])->name('reminders.snooze');
   Route::resource('reminders', ReminderController::class);
   Route::post('/habits/{habit}/log', [HabitController::class, 'logCompletion'])->name('habits.log');
   Route::resource('habits', HabitController::class);
   Route::resource('ideas', IdeaController::class);
   Route::resource('reflections', WeeklyReflectionController::class);
});
require __DIR__.'/auth.php';

