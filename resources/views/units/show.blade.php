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

    {{ Breadcrumbs::render('units.show', $subject, $unit) }}

    <div class="flex max-w-7xl mx-auto mt-2 px-4 sm:px-6 lg:px-8 text-lg text-gray-800 dark:text-gray-200 leading-tight">
        @include('components.side-bar')
        
        <x-lesson-content class="text-xl leading-9">
            <div>
                Welcome to unit "{{ $unit->name }}"!
                Choose a lesson from left sidebar.
            </div>
            @subject($subject)
            <div class="mt-auto">
                <form class="mt-2" method="POST" action="{{ route('units.change', [$subject, $unit]) }}">
                    @csrf
                    <x-primary-button>
                        @if ($unit->status == 'awaiting')
                            Опубликовать
                        @else
                            Скрыть
                        @endif
                    </x-primary-button>
                </form>
            </div>
            @endsubject
        </x-lesson-content>
    </div>

</x-app-layout>
