<div id="lessonContent" {{ $attributes->merge(['class' => 'flex overflow-y-auto flex-col ml-2 py-6 px-10 rounded-lg bg-white dark:bg-gray-800', 'style'=>'width:75%; height: 80vh;'])}}> {{-- lessons and activities --}}
    {{ $slot }}
</div>