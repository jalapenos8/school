<div id="lessonContent" {{ $attributes->merge(['class' => 'flex overflow-y-auto flex-col ml-2 px-10 rounded-lg bg-white dark:bg-gray-800', 'style'=>'width:75%; height: calc(100vh - 190px);'])}}> {{-- lessons and activities --}}
    {{ $slot }}
</div>