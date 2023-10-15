<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit subject') }}
        </h2>
    </x-slot>

    <div class="py-6 pt-6 flex flex-col sm:justify-center items-center pt-1 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('subjects.update', [$subject]) }}">
                @csrf
                @method('patch')
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $subject->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- grade -->
                <div>
                    <x-input-label for="grade" :value="__('Grade')" />
                    <x-select-input id="grade" name="grade" :options="[7,8,9,10,11,12]" :select="old('grade', $subject->grade)" required/>
                    <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                </div>

                <!-- Image link -->
                <div>
                    <x-input-label for="img" :value="__('Image link')" />
                    <x-text-input id="img" class="block mt-1 w-full" type="text" name="img" :value="old('img', $subject->img)"  />
                    <x-input-error :messages="$errors->get('img')" class="mt-2" />
                </div>

                <div>
                    <label for="teachers[]" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                    <x-select-multiple name="teachers[]" id="teachers">
                        @foreach ($users as $user)
                            <option {{ $user->subjects->contains($subject) ? 'selected' : '' }} class="py-0.5" value="{{ $user->id }}">{{ $user->name }} {{ $user->middlename }} {{ $user->surname }}</option>
                        @endforeach
                    </x-select-multiple>
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
