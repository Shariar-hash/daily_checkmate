<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('color')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_list_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->string('priority')->default('medium');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('reminder_time');
            $table->boolean('is_snoozed')->default(false);
            $table->dateTime('snoozed_until')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('habits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('frequency');
            $table->integer('streak')->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->date('completed_date');
            $table->timestamps();
        });

        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('theme')->default('light');
            $table->boolean('break_reminders')->default(true);
            $table->integer('break_interval')->default(60);
            $table->timestamps();
        });

        Schema::create('weekly_reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('week_start');
            $table->text('achievements');
            $table->text('challenges');
            $table->text('next_week_goals');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_reflections');
        Schema::dropIfExists('user_settings');
        Schema::dropIfExists('ideas');
        Schema::dropIfExists('habit_logs');
        Schema::dropIfExists('habits');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('todo_lists');
    }
};