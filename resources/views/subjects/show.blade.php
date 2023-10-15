<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $subject->name }}
        </h2>
        @can('subjects')
        <a class="ml-2" href="{{ route('subjects.edit', $subject) }}"><x-secondary-button>Edit</x-secondary-button></a>
        <a class="ml-2" href="{{ route('subjects.delete', $subject) }}"><x-danger-button>Delete</x-danger-button></a>
        @endcan
    </x-slot>

    {{ Breadcrumbs::render('subjects.show', $subject) }}

    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 pt-6 flex flex-col sm:justify-center items-center pt-1">
        <div class="w-full grid grid-cols-4 bg-white dark:bg-gray-800 text-xl text-gray-800 dark:text-gray-200 text-center border border-slate-400">
            <div class="border-b border-slate-200 py-8">I</div>
            <div class="border-b border-slate-200 py-8">II</div>
            <div class="border-b border-slate-200 py-8">III</div>
            <div class="border-b border-slate-200 py-8">IV</div>
            <div class="border-r border-slate-600 flex flex-col justify-end">
                @foreach ($units as $unit)
                    @if ($unit->term == 1)
                        @if($unit->status == 'published')
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full" ><a href="{{ route('units.show', [$subject, $unit])}}">{{ $unit->name }}</a></div> 
                        @else
                        @subject($subject)
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full text-gray-700 dark:text-gray-500" ><a href="{{ route('units.show', [$subject, $unit])}}">({{ $unit->name }})</a></div>
                        @endsubject
                        @endif                 
                        @endif
                @endforeach
                @subject($subject)
                <form class="flex items-center p-3" method="POST" action="{{ route('units.store', [$subject]) }}">
                    @csrf
                    <input type="hidden" name="term" type="text" value="1">
                    <x-text-input placeholder="Новый раздел" id="name" class="block w-full" type="text" name="name" required/>
                    <x-primary-button class="ml-2">
                        {{ __('Создать') }}
                    </x-primary-button>
                </form>
                @endsubject
            </div>
            <div class="border-r border-slate-600 flex flex-col justify-end">
                @foreach ($units as $unit)
                    @if ($unit->term == 2)
                        @if($unit->status == 'published')
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full" ><a href="{{ route('units.show', [$subject, $unit])}}">{{ $unit->name }}</a></div> 
                        @else
                        @subject($subject)
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full text-gray-700 dark:text-gray-500" ><a href="{{ route('units.show', [$subject, $unit])}}">({{ $unit->name }})</a></div>
                        @endsubject
                        @endif
                        @endif
                @endforeach
                @subject($subject)
                <form class="flex items-center p-3" method="POST" action="{{ route('units.store', [$subject]) }}">
                    @csrf
                    <input type="hidden" name="term" type="text" value="2">
                    <x-text-input placeholder="Новый раздел" id="name" class="block w-full" type="text" name="name" required/>
                    <x-primary-button class="ml-2">
                        {{ __('Создать') }}
                    </x-primary-button>
                </form>
                @endsubject
            </div>
            <div class="border-r border-slate-600 flex flex-col justify-end">
                @foreach ($units as $unit)
                    @if ($unit->term == 3)
                        @if($unit->status == 'published')
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full" ><a href="{{ route('units.show', [$subject, $unit])}}">{{ $unit->name }}</a></div> 
                        @else
                        @subject($subject)
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full text-gray-700 dark:text-gray-500" ><a href="{{ route('units.show', [$subject, $unit])}}">({{ $unit->name }})</a></div>
                        @endsubject
                        @endif                 
                        @endif
                @endforeach
                @subject($subject)
                <form class="flex items-center p-3" method="POST" action="{{ route('units.store', [$subject]) }}">
                    @csrf
                    <input type="hidden" name="term" type="text" value="3">
                    <x-text-input placeholder="Новый раздел" id="name" class="block w-full" type="text" name="name" required/>
                    <x-primary-button class="ml-2">
                        {{ __('Создать') }}
                    </x-primary-button>
                </form>
                @endsubject
            </div>
            <div class="flex flex-col justify-end">
                @foreach ($units as $unit)
                    @if ($unit->term == 4)
                        @if($unit->status == 'published')
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full" ><a href="{{ route('units.show', [$subject, $unit])}}">{{ $unit->name }}</a></div> 
                        @else
                        @subject($subject)
                            <div class="border-b border-slate-600 h-full flex items-center justify-center p-3 py-5 w-full text-gray-700 dark:text-gray-500" ><a href="{{ route('units.show', [$subject, $unit])}}">({{ $unit->name }})</a></div>
                        @endsubject
                        @endif                 
                        @endif
                @endforeach
                @subject($subject)
                <form class="flex items-center p-3" method="POST" action="{{ route('units.store', [$subject]) }}">
                    @csrf
                    <input type="hidden" name="term" type="text" value="4">
                    <x-text-input placeholder="Новый раздел" id="name" class="block w-full" type="text" name="name" required/>
                    <x-primary-button class="ml-2">
                        {{ __('Создать') }}
                    </x-primary-button>
                </form>
                @endsubject
            </div>
        </div>
    </div>

</x-app-layout>
