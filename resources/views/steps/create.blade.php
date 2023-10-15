<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new step') }}
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('steps.create', $subject, $unit, $lesson) }}

    <div class="flex justify-center mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="theory-tab" data-tabs-target="#theory" type="button" role="tab" aria-controls="theory" aria-selected="false">Theory</button>
            </li>
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="file-tab" data-tabs-target="#file" type="button" role="tab" aria-controls="file" aria-selected="false">File</button>
            </li>
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="video-tab" data-tabs-target="#video" type="button" role="tab" aria-controls="video" aria-selected="false">Video</button>
            </li>
            <li class="mr-1" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="interactive-tab" data-tabs-target="#interactive" type="button" role="tab" aria-controls="interactive" aria-selected="false">Interactive</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="whiteboard-tab" data-tabs-target="#whiteboard" type="button" role="tab" aria-controls="whiteboard" aria-selected="false">Online whiteboard</button>
            </li>
        </ul>
    </div>
    <div id="myTabContent" class="flex items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="hidden w-full px-16 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="theory" role="tabpanel" aria-labelledby="theory-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.store', [$subject, $unit, $lesson]) }}">
                @csrf
                
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="theory">
            
                <input type="hidden" name="content" id="editor-content" type="text" value="<p>Hello, World!</p>">

                <div class="mt-4 rounded-xl bg-white text-xl">
                    <x-tinymce-editor><p>Hello, World!</p></x-tinymce-editor>
                </div>                

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="w-full hidden px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="file" role="tabpanel" aria-labelledby="file-tab">
            <form method="POST" enctype="multipart/form-data" spellcheck="false" action="{{ route('steps.store', [$subject, $unit, $lesson]) }}">
                @csrf
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="file">
            
                <div class="w-full">
                    <x-input-label for="content" :value="__('Upload file')" />
                    <x-input-file class="mt-1" id="content" name="content" :value="old('content')" required />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="w-full hidden px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="video" role="tabpanel" aria-labelledby="video-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.store', [$subject, $unit, $lesson]) }}">
                @csrf
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="video">
            
                <div class="w-full">
                    <x-input-label for="content" :value="__('Youtube Video link')" />
                    <x-text-input placeholder="https://www.youtube.com/watch?v=ktEynuuRjF0" id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="w-full hidden px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="interactive" role="tabpanel" aria-labelledby="interactive-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.store', [$subject, $unit, $lesson]) }}">
                @csrf
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="interactive">
            
                <div class="w-full">
                    <x-input-label for="content" :value="__('Wordwall activity link')" />
                    <x-text-input placeholder="https://wordwall.net/play/56710/123/809" id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="w-full hidden px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="whiteboard" role="tabpanel" aria-labelledby="whiteboard-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.store', [$subject, $unit, $lesson]) }}">
                @csrf
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <input type="hidden" name="type" type="text" value="whiteboard">
                <input type="hidden" name="content" type="text" value="empty">

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <x-tinymce-config/>
    <script>

    </script>
</x-app-layout>
