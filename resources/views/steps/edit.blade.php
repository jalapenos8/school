<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit step') }}
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('steps.edit', $subject, $unit, $lesson, $step) }}

    <div id="myTabContent" class="flex items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        @if($step->type == 'theory')
        <div class="w-full px-16 py-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="theory" role="tabpanel" aria-labelledby="theory-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.update', [$subject, $unit, $lesson, $step]) }}">
                @csrf
                @method('patch')
                
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $step->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="theory">
                
                <input type="hidden" name="content" id="editor-content" type="text" value="<p>Hello, World!</p>">

                <div class="mt-4 rounded-xl bg-white text-xl">
                    <x-tinymce-editor>{{ $step->content }}</x-tinymce-editor>
                </div>                

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @elseif($step->type == 'file')
        <div class="w-full px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="file" role="tabpanel" aria-labelledby="file-tab">
            <form method="POST" enctype="multipart/form-data" spellcheck="false" action="{{ route('steps.update', [$subject, $unit, $lesson, $step]) }}">
                @csrf
                @method('patch')
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $step->name)" required />
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
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <script>
            console.log("{{ asset('storage/'.$step->content)}}");
            fetch("{{ asset('storage/'.$step->content)}}")
            .then(res => res.blob())
            .then(blob => {
                let url = "{{ $step->content }}";
                var filename = url.split('/').pop()
                var file = new File([blob], filename);
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);//your file(s) reference(s)
                document.getElementById('content').files = dataTransfer.files;
            });
        </script>
        @elseif($step->type == 'video')
        <div class="w-full px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="video" role="tabpanel" aria-labelledby="video-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.update', [$subject, $unit, $lesson, $step]) }}">
                @csrf
                @method('patch')
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $step->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="video">
            
                <div class="w-full">
                    <x-input-label for="content" :value="__('Youtube Video link')" />
                    <x-text-input placeholder="https://www.youtube.com/watch?v=ktEynuuRjF0" id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content', $step->content)" required />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @elseif($step->type == 'interactive')
        <div class="w-full px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="interactive" role="tabpanel" aria-labelledby="interactive-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.update', [$subject, $unit, $lesson, $step]) }}">
                @csrf
                @method('patch')
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $step->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <input type="hidden" name="type" type="text" value="interactive">
            
                <div class="w-full">
                    <x-input-label for="content" :value="__('Wordwall activity link')" />
                    <x-text-input placeholder="https://wordwall.net/play/56710/123/809" id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content', $step->content)" required />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @elseif($step->type == 'whiteboard')
        <div class="w-full px-16 p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="whiteboard" role="tabpanel" aria-labelledby="whiteboard-tab">
            <form method="POST" spellcheck="false" action="{{ route('steps.update', [$subject, $unit, $lesson, $step]) }}">
                @csrf
                @method('patch')
                
                <div class="w-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $step->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                
                <input type="hidden" name="type" type="text" value="whiteboard">
                <input type="hidden" name="content" type="text" value="empty">

                <div class="flex items-center justify-between mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @endif
    </div>
    <x-tinymce-config/>
    <script>

    </script>
</x-app-layout>
