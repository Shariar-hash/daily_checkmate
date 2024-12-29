<?php

namespace App\Providers;

use App\Models\TodoList;
use App\Models\Habit; // Add Habit Model
use App\Policies\TodoListPolicy;
use App\Policies\HabitPolicy; // Add Habit Policy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        TodoList::class => TodoListPolicy::class,
        Habit::class => HabitPolicy::class, // Map Habit model to HabitPolicy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register any custom gates here if needed
    }
}
