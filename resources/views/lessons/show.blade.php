<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('units.show', [$subject, $unit])}}">{{ $unit->name }}</a>
        </h2>
        @subject($subject)
            <a class="ml-2" href="{{ route('units.edit', [$subject, $unit]) }}"><x-secondary-button>Edit</x-secondary-button></a>
            <a class="ml-2" href="{{ route('units.delete', [$subject, $unit]) }}"><x-danger-button>Delete</x-danger-button></a>
        @endsubject
    </x-slot>

    {{ Breadcrumbs::render('lessons.show', $subject, $unit, $lesson) }}

    <div class="flex max-w-7xl pb-2 mx-auto mt-2 px-4 sm:px-6 lg:px-8 text-lg text-gray-800 dark:text-gray-200 leading-tight">
        @include('components.side-bar')
        
        <x-lesson-content class="text-xl leading-9">
            <div class="flex flex-col min-h-full py-6">
                <div class="w-full flex"><span class="text-2xl">{{ $lesson->name }}</span>

                @subject($subject)
                    <a class="ml-6" href="{{ route('lessons.edit', [$subject, $unit, $lesson]) }}"><x-secondary-button>Edit</x-secondary-button></a>
                    <a class="ml-2" href="{{ route('lessons.delete', [$subject, $unit, $lesson]) }}"><x-danger-button>Delete</x-danger-button></a>
                @endsubject
                </div>
                <div class="my-4">
                    Welcome to lesson "{{ $lesson->name }}"!
                    Choose a lesson from left sidebar.
                </div>

                @subject($subject)
                <div class="mt-auto">
                    <a class="mt-4" href="{{ route('steps.create', [$subject, $unit, $lesson]) }}"><x-secondary-button>Create new step</x-secondary-button></a>
                </div>
                @endsubject
            </div>
        </x-lesson-content>
    </div>

</x-app-layout>
