<?php
session_start();

session(['QuestArr' => array()]);
session(['count' => 0]);

?>
<x-quiz-layout>
  
    <script type="text/javascript">
        let subjectID = <?php echo $subject->id; ?>;
        let unitID = <?php echo $unit->id; ?>;
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new quiz') }}
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('quizzes.create', $subject, $unit) }}

    <div class="createQuiz_MainContainer min-h-screen">
        <div class="createQuizContainer">
          <div class="contHeadPart">
            <div class="contAngle w-60">
              <img src="/storage/resources/alarm-fill.svg">
              <select id="timerInp" class="timerInp form-select font4">
                  <option value="10">10</option>
                  <option value="15" selected>15</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                  <option value="60">60</option>
                  <option value="90">90</option>
                  <option value="120">120</option>
              </select>
              <span class="text-white font_size1">s</span>
            </div>                    
            <div class="Header3 text-white text-center w-full"><div id="QuestionNum">Question 1</div></div>
            <div class="contAngle">
              <button id="Del_btn" class="w-40">Delete question</button>
            </div>
          </div>
          <div id="MainContainer">
            
            
              
          </div>
        </div>
  
        <div id="toolsSection" class="toolsContainerWrapper">
          <div class="toolsContainer">
            
            <x-dropdown align="right" width="48" id="AddTestQGroup" class="btn-group">
              <x-slot name="trigger">
              <button id="Add_btn" class="button1" data-bs-toggle="dropdown"><i class="fa-solid fa-plus fa-2xl"></i><span>Add a task</span></button>
              </x-slot>
              <x-slot name="content" id="newTaskAddDropdown" class="bg-light">
                <x-dropdown-link><button id="TestQuestion" class="w-full py-1 newTaskClicked">Test Question</button></x-dropdown-link>
                <x-dropdown-link><button id="GroupSort" class="w-full py-1 newTaskClicked">Group Sorting</button></x-dropdown-link>
                <x-dropdown-link><button id="PutInOrder" class="w-full py-1 newTaskClicked">Put In Order</button></x-dropdown-link>
                <x-dropdown-link><button id="FillMissingWords" class="w-full py-1 newTaskClicked">Fill In Missing Words</button></x-dropdown-link>
                <x-dropdown-link><button id="TermToDef" class="w-full py-1 newTaskClicked">Term To Definition</button></x-dropdown-link>
              </x-slot>
            </x-dropdown>
            {{-- <div id="AddTestQGroup" class="btn-group">
              <button id="Add_btn" class="button1" data-bs-toggle="dropdown"><i class="fa-solid fa-plus fa-2xl"></i><span>Add a task</span></button>
              <div id="newTaskAddDropdown" class="dropdown-menu dropdown-menu-end bg-light">
                <button id="TestQuestion" class="dropdown-item newTaskClicked">Test Question</button>
                <button id="GroupSort" class="dropdown-item newTaskClicked">Group Sorting</button>
                <button id="PutInOrder" class="dropdown-item newTaskClicked">Put In Order</button>
                <button id="FillMissingWords" class="dropdown-item newTaskClicked">Fill In Missing Words</button>
                <button id="TermToDef" class="dropdown-item newTaskClicked">Term To Definition</button>
              </div>
            </div> --}}
            
            <button id="Save_btn" class="hidden button5"><i class="fa-solid fa-check fa-2xl"></i><span>Save a task</span></button>
            <div class="btn-group dropleft">
              <button id="listShow_btn" class="button4" data-bs-toggle="dropdown"><i class="fa-solid fa-list-ul fa-2xl"></i></button>
              <div id="QuestListCont" class="dropdown-menu">
                <p>Tasks created:</p>
                <div id="createdQuestionsContainer">
                  <ol>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        
          <div class="toolsContainer">
            <div class="btn_group">
              <button id="Exit_btn" class="button2"><i class="fa-solid fa-xmark fa-2xl"></i><span>Exit</span></button>
              <hr class="my-2">
              <button id="Finish_btn" class="button1"><i class="fa-solid fa-share-from-square fa-2xl"></i><span>Post</span></button>
            </div>
          </div>
        </div>
      </div>


      <div class="PostQuizContainer container-fluid">
        <div id="PostQuizFormContainer" class="PostQuizFormContainer">
          <div class="Header2 text-white text-center">Quiz Info</div>
          <div class="input_group">
            @csrf
            <input id="QuizName" type="text" class="textInput1 Regular" placeholder="Name">
            <textarea id="QuizDescription" maxlength="300" class="Regular" rows="4" placeholder="Description"></textarea>
          </div>
          <div class="btn_group">
            <button id="Post_btn" class="button1 Regular">Post</button>
            <button id="Back_btn" class="button2 Regular">Back</button>
          </div>
        </div>
      </div>
      @vite(['resources/js/createquiz.js'])
</x-quiz-layout>
