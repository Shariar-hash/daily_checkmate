<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\HabitController;

Route::resource('todos', TodoController::class);
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::resource('reminders', ReminderController::class);
Route::resource('habits', HabitController::class);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::post('/todos/{todo}/mark-done', [TodoController::class, 'markDone'])->name('todos.markDone');
