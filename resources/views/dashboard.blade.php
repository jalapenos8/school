<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-2xl text-white">Доступные предметы ></div>
            @foreach ([7,8,9,10,11,12] as $n)    
                <div class="my-4 text-lg text-white mb-4">{{$n}}-класс ></div>
                <div class="flex text-lg overflow-y-auto shadow-sm sm:rounded-lg">
                    <?php $count = 0 ?>
                    @foreach ($subjects as $subject)
                        @if($subject->grade == $n)
                            <div class="relative mr-4 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                <div class="absolute z-10 w-full right-0 left-0 top-0 bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center px-0.5 leading-none rounded-full" style="width: {{ $subject->done }}">{{ $subject->done }}</div>
                                </div>
                                <a href="{{ route('subjects.show', $subject->id) }}" class="block bg-center bg-cover w-64 h-64" style="background-image: url('{{$subject->img}}')"></a>
                                <a class="flex justify-center align-center mt-2 text-xl w-64" href="{{ route('subjects.show', $subject->id) }}">{{ $subject->name }}</a>
                            </div>
                            <?php $count++; ?>
                        @endif
                    @endforeach
                    @if ($count == 0)
                        <div class="text-sm text-white mb-4">К сожалению, предметы отсутствуют для этого класса.</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
