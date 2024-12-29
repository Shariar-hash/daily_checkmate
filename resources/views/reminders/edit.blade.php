@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Edit Reminder</h1>
                <p class="mt-2 text-sm text-gray-600">Update your reminder details</p>
            </div>

            <form action="{{ route('reminders.update', $reminder) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $reminder->title) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description', $reminder->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reminder_time" class="block text-sm font-medium text-gray-700">Reminder Time</label>
                    <input type="datetime-local" 
                           name="reminder_time" 
                           id="reminder_time"
                           value="{{ old('reminder_time', $reminder->reminder_time->format('Y-m-d\TH:i')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('reminder_time') border-red-500 @enderror"
                           required>
                    @error('reminder_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                    <div class="mt-1 flex items-center space-x-2">
                        <input type="color" 
                               name="color" 
                               id="color"
                               value="{{ old('color', $reminder->color ?? '#4F46E5') }}"
                               class="h-8 w-8 rounded-md border border-gray-300 cursor-pointer">
                        <span class="text-sm text-gray-500">Choose a color for your reminder</span>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($reminder->is_snoozed)
                <div class="bg-blue-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Reminder is Snoozed</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Snoozed until: {{ $reminder->snoozed_until->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex items-center justify-between pt-4">
                    <div>
                        <button type="button"
                                onclick="document.getElementById('delete-form').submit()"
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Reminder
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reminders.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Reminder
                        </button>
                    </div>
                </div>
            </form>

            <!-- Delete Form -->
            <form id="delete-form" action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <!-- Snooze Form -->
            @if(!$reminder->is_snoozed)
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Snooze Reminder</h3>
                <form action="{{ route('reminders.snooze', $reminder) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <label for="snooze_until" class="block text-sm font-medium text-gray-700">Snooze Until</label>
                            <input type="datetime-local" 
                                   name="snooze_until" 
                                   id="snooze_until"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   required>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Snooze
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for color input */
    input[type="color"] {
        -webkit-appearance: none;
        padding: 0;
    }
    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    input[type="color"]::-webkit-color-swatch {
        border: none;
        border-radius: 0.375rem;
    }
</style>
@endpush