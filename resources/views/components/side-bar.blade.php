<div class="flex overflow-y-auto flex-col px-4 rounded-lg bg-white dark:bg-gray-800 w-1/4" style="height: 80vh;"> {{-- lessons and activities --}}
    <p class="py-2 text-2xl text-center">Lessons</p>
    <ol class="">
        @foreach ($lessons as $lesson)
            <li class="list-none py-1 px-3 mb-1 dark:bg-gray-900 rounded break-all">
                @if($lesson->type == 'lesson')
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <a class="text-xl font-medium" href="{{ route('lessons.show', [$subject, $unit, $lesson]) }}">
                     {{ $lesson->name }}</a>
                <ol class="list-none ml-2 my-1">
                    @foreach ($steps as $step)
                        @if ($step->lesson_id == $lesson->id)
                            <li class="py-1 mb-1 dark:bg-gray-900 break-all">
                                @if ($step->type == 'theory')
                                <i class="fa fa-file-text" aria-hidden="true"></i>  
                                @elseif($step->type == 'file')
                                <i class="fa fa-file" aria-hidden="true"></i>  
                                @elseif($step->type == 'video')
                                <i class="fa fa-play" aria-hidden="true"></i>  
                                @elseif($step->type == 'interactive')
                                <i class="fa fa-hand-o-up" aria-hidden="true"></i>  
                                @elseif($step->type == 'test')
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>  
                                @elseif($step->type == 'quiz')
                                <i class="fa fa-puzzle-piece" aria-hidden="true"></i>  
                                @elseif($step->type == 'whiteboard')
                                <i class="fa fa-desktop" aria-hidden="true"></i>                                      
                                @endif

                                @if ($step->users->contains(Auth::user()->id))
                                    <i class="pl-1 fa fa-check text-green-500" aria-hidden="true"></i> 
                                @endif
                                
                                <a class="pl-1" href="{{ route('steps.show',[$subject, $unit, $lesson, $step]) }}">{{ $step->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
                @elseif($lesson->type == 'quiz')
                    <i class="fa fa-circle-question" aria-hidden="true"></i>
                    @if (auth()->user()->steps->contains($lesson->steps()->latest()->first()->id))
                        <i class="pl-1 fa fa-check text-green-500" aria-hidden="true"></i> 
                    @endif
                    <a class="pl-1 font-medium" href="{{ route('quizzes.show', [$subject, $unit, $lesson]) }}">{{ $lesson->name }}</a>
                @endif
            </li>
        @endforeach
    </ol>
    @subject($subject)
    <a class="mt-2 mx-auto w-max" href="{{ route('lessons.create', [$subject, $unit]) }}"><x-secondary-button>Create new lesson</x-secondary-button></a>
    <a class="mt-2 mx-auto w-max" href="{{ route('quizzes.create', [$subject, $unit]) }}"><x-secondary-button>Create new quiz</x-secondary-button></a>
    @endsubject
</div>