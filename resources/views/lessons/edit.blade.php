<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit lesson') }}
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('lessons.edit', $subject, $unit, $lesson) }}

    <div class="max-w-7xl mx-auto py-4 pt-6 px-4 sm:px-6 lg:px-8 flex flex-col sm:justify-center items-center pt-1 bg-gray-100 dark:bg-gray-900">
        <div class=" w-full px-6 py-4 rounded-lg bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form class="w-full" method="POST" action="{{ route('lessons.update', [$subject, $unit, $lesson]) }}">
                @csrf
                @method('patch')
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $lesson->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description', $lesson->name)"/>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            
                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>            
    </div>
</x-app-layout>
