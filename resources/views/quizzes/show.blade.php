<?php
session_start();

// array of quizzes => $_SESSION['QuestArr']
// user id => $StudID

session(['count' => $count]);

?>
<x-quiz-layout>
  
    <script type="text/javascript">
        let subjectID = <?php echo $subject->id; ?>;
        let unitID = <?php echo $unit->id; ?>;
        let quizID = <?php echo $quiz->id; ?>;
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>
    
    {{ Breadcrumbs::render('lessons.show', $subject, $unit, $quiz) }}

    <div class="relative quizInterfaceMainContainer min-h-screen">
        <div class="absolute z-10 w-full right-0 left-0 top-0 bg-gray-200 rounded-full dark:bg-gray-700">
          <div id="thisProg" class="bg-blue-600 hidden text-md font-medium text-blue-100 text-center p-0 leading-none rounded-full">&nbsp;</div>
        </div>
        <div id="MainContainer" class="quizInterfaceContainer">

        </div>
    </div>

    <script src="/js/quizInterface.js"></script>
</x-quiz-layout>
