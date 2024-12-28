<nav class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                        {{ config('app.name', 'Productivity App') }}
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link href="{{ route('todo-lists.index') }}" :active="request()->routeIs('todo-lists.*')">
                        Todo Lists
                    </x-nav-link>
                    <x-nav-link href="{{ route('reminders.index') }}" :active="request()->routeIs('reminders.*')">
                        Reminders
                    </x-nav-link>
                    <x-nav-link href="{{ route('habits.index') }}" :active="request()->routeIs('habits.*')">
                        Habits
                    </x-nav-link>
                    <x-nav-link href="{{ route('ideas.index') }}" :active="request()->routeIs('ideas.*')">
                        Ideas
                    </x-nav-link>
                    <x-nav-link href="{{ route('reflections.index') }}" :active="request()->routeIs('reflections.*')">
                        Reflections
                    </x-nav-link>
                    <x-nav-link href="{{ route('fullcalender.index') }}" :active="request()->routeIs('fullcalender.*')">
                        Event Calender
                    </x-nav-link>
                    
                </div>
            </div>
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>