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

    {{ Breadcrumbs::render('steps.show', $subject, $unit, $lesson, $step) }}

    <div class="flex max-w-7xl pb-4 mx-auto mt-2 px-4 sm:px-6 lg:px-8 text-lg text-gray-800 dark:text-gray-200 leading-tight">
        @include('components.side-bar')
        
        <x-lesson-content class="text-xl leading-9">
            <div class="flex items-center w-full">
                <span class="text-2xl">{{ $step->name }}</span>

                @if ($step->users->contains(Auth::user()->id))
                    <i class="pl-1 fa fa-check text-green-500 px-2" aria-hidden="true"></i> 
                @endif
                    
                @subject($subject)
                    <a class="ml-6" href="{{ route('steps.edit', [$subject, $unit, $lesson, $step]) }}"><x-secondary-button>Edit</x-secondary-button></a>
                    <a class="ml-2" href="{{ route('steps.delete', [$subject, $unit, $lesson, $step]) }}"><x-danger-button>Delete</x-danger-button></a>
                @endsubject
            </div>
            <div class="w-full h-full mt-4">
                @if($step->type == 'theory')
                    <?php print_r($step->content); ?>
                @elseif($step->type == 'file')
                    <a href="{{ asset('storage/'.$step->content)}}">Скачать файл</a>
                @elseif($step->type == 'video')
                    <?php
                        $parts = parse_url($step->content);
                        parse_str($parts['query'], $query);
                    ?>
                    <iframe class="mx-auto" width="90%" height="90%" modestbranding rel=0 showinfo=0 controls=0 src="https://www.youtube.com/embed/{{ $query['v'] }}?rel=0&showinfo=0"  allowfullscreen></iframe>
                @elseif($step->type == 'interactive')
                    <?php
                        $playId = explode("play", $step->content);
                    ?>
                    <iframe width="100%" height="100%" class="mx-auto" src="https://wordwall.net/embed/play{{ $playId[1] }}" frameborder="0" allowfullscreen></iframe>
            
                    </form>
                @elseif($step->type == 'whiteboard')
                
                @endif
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('steps.submit', [$subject, $unit, $lesson, $step]) }}">
                        @csrf
                        <x-primary-button>
                            {{ __('Next step') }}
                        </x-primary-button>
                    </form>
                    @subject($subject)
                        <a href="{{ route('steps.create', [$subject, $unit, $lesson]) }}"><x-secondary-button>Create new step</x-secondary-button></a>
                    @endsubject
                </div>
            </div>
        </x-lesson-content>
    </div>
    <x-tinymce-config/>
</x-app-layout>
