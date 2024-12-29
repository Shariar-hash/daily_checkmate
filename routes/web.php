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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('fullcalender', [FullCalenderController::class, 'index']);
Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);
Route::resource('fullcalender', FullCalenderController::class);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Reminders
    Route::resource('reminders', ReminderController::class);
    Route::post('reminders/{reminder}/snooze', [ReminderController::class, 'snooze'])->name('reminders.snooze');

    // Habits
    Route::resource('habits', HabitController::class);
    Route::post('/habits/{habit}/log', [HabitController::class, 'logCompletion'])->name('habits.log');

    // Todo Lists
    Route::get('/todo-lists/archived', [TodoListController::class, 'archived'])->name('todo-lists.archived');
    Route::post('/todo-lists/{todoList}/archive', [TodoListController::class, 'archive'])->name('todo-lists.archive');
    Route::post('/todo-lists/{todoList}/restore', [TodoListController::class, 'restore'])->name('todo-lists.restore');
    Route::resource('todo-lists', TodoListController::class);

    // Ideas and Reflections
    Route::resource('ideas', IdeaController::class);
    Route::resource('reflections', WeeklyReflectionController::class);

    // Breaks
    Route::get('/breaks', [BreakController::class, 'index'])->name('breaks.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';