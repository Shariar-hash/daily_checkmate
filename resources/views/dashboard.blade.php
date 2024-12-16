<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
</head>
<body>
   <h1>Dashboard</h1>
  
   <ul>
       <li><a href="{{ route('todo-lists.index') }}">Manage Todo Lists</a></li>
       <li><a href="{{ route('tasks.store', ['todoList' => 1]) }}">Add Task</a></li>
       <li><a href="{{ route('habits.index') }}">Manage Habits</a></li>
       <li><a href="{{ route('ideas.index') }}">Manage Ideas</a></li>
       <li><a href="{{ route('reminders.index') }}">Manage Reminders</a></li>
       <li><a href="{{ route('reflections.index') }}">Weekly Reflections</a></li>
   </ul>
</body>
</html>