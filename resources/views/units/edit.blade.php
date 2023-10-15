<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit unit') }}
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('units.edit', $subject, $unit) }}

    <div class="py-6 pt-6 flex flex-col sm:justify-center items-center pt-1 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('units.update', [$subject, $unit]) }}">
                @csrf
                @method('patch')
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $unit->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Term -->
                <div>
                    <x-input-label for="term" :value="__('Term')" />
                    <x-select-input id="term" name="term" :options="[1,2,3,4]" :select="old('term', $unit->term)" required/>
                    <x-input-error :messages="$errors->get('term')" class="mt-2" />
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
