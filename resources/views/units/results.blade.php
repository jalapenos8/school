<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Результаты
        </h2>
    </x-slot>

    <div class="py-8 flex max-w-7xl mx-auto mt-2 px-4 sm:px-6 lg:px-8 text-lg text-gray-800 dark:text-gray-200 leading-tight">
        @foreach ($subjects as $subject)
        @if($subject->stepsDone != 0 && $subject->stepsHas != 0)
        <div class="w-full rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            <div class="flex flex-col w-full p-8">
                <div class="flex w-full rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <div class="flex">
                        <a href="{{ route('subjects.show', $subject) }}" class="block rounded-md bg-center bg-no-repeat w-32 h-32" style="background-size: 170%; background-image: url('{{ $subject->img }}')"></a>
                    </div>
                    <div class="flex flex-col ml-8 w-full">
                        <a class="flex align-center font-medium text-3xl" href="{{ route('subjects.show', $subject) }}">{{ $subject->name }}</a>
                    
                        <div class="mt-5 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center leading-none rounded-full" style="width: {{ floor($subject->stepsDone*100/$subject->stepsHas) }}%">&nbsp;</div>
                        </div> 
                        <div class="flex flex-col text-md mt-2 text-gray-800 dark:text-gray-400 items-end">
                            <span>{{ floor($subject->stepsDone*100/$subject->stepsHas) }}% материала пройдено</span>
                            <span>{{ $subject->stepsDone }}/{{ $subject->stepsHas }} баллов получено</span>
                        </div>
                    </div>
                </div>
                @php
                    $term = 1;
                @endphp
                @foreach ($subject->units as $unit)
                @if($unit->status == 'published' && $unit->stepsHas != 0)
                <div data-modal-target="modalForUnit{{ $unit->id }}" data-modal-toggle="modalForUnit{{ $unit->id }}" id="{{ $unit->id }}" class="unitModal w-full mt-8 grid grid-cols-2 gap-4 text-lg overflow-y-auto sm:rounded-lg">
                    <div class="p-4 cursor-pointer rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-col w-full">
                            <a class="flex justify-left align-center text-2xl" href="{{ route('units.show', [$subject, $unit->id]) }}">{{ $unit->name }}</a>
                        
                            <div class="mt-4 w-full bg-gray-200 rounded-full dark:bg-gray-800">
                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center leading-none rounded-full" style="width: {{ floor($unit->stepsDone*100/$unit->stepsHas) }}%">&nbsp;</div>
                            </div> 
                            <div class="flex flex-col text-md mt-1 text-gray-800 dark:text-gray-400 items-end">
                                <span>{{ floor($unit->stepsDone*100/$unit->stepsHas) }}% материала пройдено</span>
                                <span>{{ $unit->stepsDone }}/{{ $unit->stepsHas }} баллов получено</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if($unit->term > $term)
                    <div class="mt-6 border-t w-full"></div>
                    @php
                        $term = $unit->term;
                    @endphp
                @endif
                <x-our-modal id="modalForUnit{{ $unit->id }}">
                    <x-slot name="header">
                        Детальный отчет о разделе {{ $unit->name }}
                    </x-slot>
                    <div class="flex flex-col w-full">
                        @foreach ($unit->lessons as $lesson)
                        @if($lesson->stepsHas != 0)
                        <div class="relative flex overflow-hidden w-full h-full mt-1 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            <div class="flex min-h-full bg-gray-200 dark:bg-gray-700">
                                <div class="mt-auto bg-blue-600 text-xs text-blue-100 text-center w-3 leading-none" style="height: {{ floor($lesson->stepsDone*100/$lesson->stepsHas) }}%">&nbsp;</div>
                            </div> 
                            <div class="m-4 ml-6">{{ $lesson->name }}</div>
                            <div class="m-4 mr-8 ml-auto">{{ $lesson->stepsDone }}/{{ $lesson->stepsHas }}</div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </x-our-modal>
                @endif
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <script src="/js/results.js"></script>
</x-app-layout>
