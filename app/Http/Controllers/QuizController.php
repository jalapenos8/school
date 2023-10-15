<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\Objective;
use App\Models\Step;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Task {
    public $Name;
    public $TaskObj;
    public $Timer;

    public function __construct($Name, $TaskObj, $Timer) {
        $this->Name = $Name;
        $this->TaskObj = $TaskObj;
        $this->Timer = $Timer;
    }
}
class TestQuestion {
    public $quest;
    public $opts; // array
    public $ans;

    public function __construct($quest, $opts, $ans) {
        $this->quest = $quest;
        $this->opts = $opts;
        $this->ans = $ans;
    }
}
class GroupSort {
    public $group; // name of the group
    public $items; // подлежащие

    public function __construct($group, $items) {
        $this->group = $group;
        $this->items = $items;
    }
}   
class PutInOrder {
    public $sentence;
    public $words;

    public function __construct($sentence, $words) {
        $this->sentence = $sentence;
        $this->words = $words;
    }
} 
class FillMissingWords {
    public $completeText;
    public $missedWords;     // array of missed words
    public $incompleteText;  // _____ instead of missed words

    public function __construct($completeText, $missedWords, $incompleteText) {
        $this->completeText = $completeText;
        $this->missedWords = $missedWords;
        $this->incompleteText = $incompleteText;
    }
}
class TermToDefItem {
    public $term;
    public $def;

    public function __construct($term, $def) {
        $this->term = $term;
        $this->def = $def;
    }
}
class TermToDefCollection {
    public $paired;
    public $singleTerms;
    public $singleDefs;

    public function __construct($paired, $singleTerms, $singleDefs) {
        $this->paired = $paired;
        $this->singleTerms = $singleTerms;
        $this->singleDefs = $singleDefs;
    }
}

function areArraysEqual($array1, $array2) {
    // Sort the arrays to ensure the elements are in the same order
    sort($array1);
    sort($array2);

    // Compare the sorted arrays to check for equality
    if ($array1 === $array2)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function shuffleArray($array) {
    $currentIndex = count($array);
    // While there remain elements to shuffle.
    while ($currentIndex != 0) {
        // Pick a remaining element.
        $randomIndex = mt_rand(0, $currentIndex - 1);
        $currentIndex--; 
        // And swap it with the current element.
        [$array[$currentIndex], $array[$randomIndex]] = [$array[$randomIndex], $array[$currentIndex]];
    }
    return $array;
}

class QuizController extends Controller
{
    public function create(Subject $subject, Unit $unit)
    {
        return view('quizzes.create')->with(compact(['subject','unit']));
    }

    public function show(Subject $subject, Unit $unit, Lesson $quiz)
    {   
        $quests = $quiz->steps;
        $count = DB::table('step_user')
            ->join('users', 'step_user.user_id', '=', 'users.id')
            ->join('steps', 'step_user.step_id', '=', 'steps.id')
            ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
            ->select('step_user.*')
            ->where('step_user.user_id', '=', auth()->user()->id)
            ->where('lessons.id', '=', $quiz->id)
            ->get()->count();
        
        return view('quizzes.show')->with(compact(['subject', 'unit', 'quiz', 'quests', 'count']));  
    }

    public function quizInterfaceSQL(Subject $subject, Unit $unit, Lesson $quiz)
    {    
        $quizContent = array();

        foreach($quiz->steps as $q){
            array_push($quizContent, json_decode($q->content));
        }
        
        session(['reqTime' => time()]);

        $theCode = '';
        $isEnd = false;
        $metadata = null;
        $timer = 0;
        if (session('count') >= count($quizContent))
        {
            $isEnd = true;
        }
        else
        {
            $QuizType = $quizContent[session('count')]->Name;
            $timer = $quizContent[session('count')]->Timer;
            switch ($QuizType) {
                case 'TestQuestion':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $letters = array('A', 'B', 'C', 'D');
                    $opts = '';
                    $metadata = count($Task->ans);
                    $Task->opts = shuffleArray($Task->opts);
    
                    for ($i = 0; $i<count($Task->opts); $i++)
                    {
                        $opt = '
                        <div class="TestQuestionOption">
                            <p class="TestQuestionOptionLetterLabel">'.$letters[$i].'</p>
                            <p class="TestQuestionOptionTextarea">'.$Task->opts[$i].'</p>
                        </div>';
                        $opts .= $opt; 
                    }
    
                    $theCode = '
                    <div id="TestContainer" class="TestContainer container-fluid">
                        <p class="TestQuestionQuestionTextarea">' . $Task->quest . '</p>
    
                        <div id="options"> 
                        ' . $opts . '
                        </div>
                    </div>';
                    break;
    
                case 'GroupSort':
                    $Task = $quizContent[session('count')]->TaskObj;
                    $Groups = '';
                    $Items = '';
                    $Task = shuffleArray($Task);
                    foreach ($Task as $GroupSort)
                    {
                        $Group = '
                        <div class="GroupCard">
                            <p class="GroupName">' . $GroupSort->group . '</p>
                            <hr>
                            <div class="ItemsContainer Cust_droppable">
    
                            </div>
                        </div>';
                        $Groups .= $Group;
                        $GroupSort->items = shuffleArray($GroupSort->items);
                        foreach ($GroupSort->items as $anItem)
                        {
                            $Item = '<div class="GroupItem shadow Cust_draggable">'.$anItem.'</div>';
                            $Items .= $Item;
                        }
                    }
    
                    $theCode = '
                    <div id="GroupSort_thisContainer" class="GSmouseOverFig GroupsContainer">
                        <div id="GroupSort_GroupsContainer" class="dCont">
                        ' . $Groups . '
                        </div>
    
                        <div id="GroupSort_ItemsContainer" class="dCont">
                        ' . $Items . '
                        </div>
                    </div>';
                    break;
    
                case 'PutInOrder':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $wordConts = '';
                    $wordBlocks = '';
                    $Task->words = shuffleArray($Task->words);
                    foreach ($Task->words as $word)
                    {
                        $wordCont = '<span class="PIO_wordCont Cust_droppable textPiece">_____</span> ';
                        $wordBlock = '<span class="textPiece Cust_draggable">'.$word.'</span>';
                        $wordConts .= $wordCont;
                        $wordBlocks .= $wordBlock;
                    }
    
                    $theCode = '
                    <div id="PutInOrder_thisContainer" class="PIOmouseOverFig">
                        <div id="PutInOrder_GroupsContainer" class="dCont">
                            <p id="PutInOrder_sentenceInput" class="Interf_sentenceInput">'.$wordConts.'</p> 
                        </div>
    
                        <div id="PutInOrder_ItemsContainer" class="dCont">
                        ' . $wordBlocks . '
                        </div>
                    </div>';
                    break;
    
                case 'FillMissingWords':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $theText = $Task->incompleteText;
                    $theText = str_replace('_____', '<span class="PIO_wordCont Cust_droppable textPiece">_____</span>', $theText);
                    $wordBlocks = '';
                    $Task->missedWords = shuffleArray($Task->missedWords);
                    foreach ($Task->missedWords as $word)
                    {
                        $wordBlock = '<span class="textPiece Cust_draggable">'.$word.'</span>';
                        $wordBlocks .= $wordBlock;
                    }
    
                    $theCode = '
                    <div id="FMW_thisContainer" class="FMWmouseOverFig">
                        <div id="FMW_GroupsContainer" class="dCont">
                            <p id="FMW_sentenceInput" class="Interf_sentenceInput">' . $theText . '</p> 
                        </div>
    
                        <div id="FMW_ItemsContainer" class="dCont">
                        ' . $wordBlocks . '
                        </div>
                    </div>';
                    break;
    
                case 'TermToDef':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $termBlocks = '';
                    $defBlocks = '';
                    $Pairs = array_merge($Task->paired, $Task->singleTerms, $Task->singleDefs);
                    $Pairs = shuffleArray($Pairs);
                    $metadata = count($Task->paired);
                    $t=1;
                    $d=1;
                    
                    for($j = 0; $j < count($Pairs); $j++)
                    {
                        if ($Pairs[$j]->term !=null)
                        {
                            $termBlock = '<div id="te'.$t.'" class="blockcol termBlock termClickable t0">'.$Pairs[$j]->term.'</div>';
                            $termBlocks .= $termBlock;
                            $t++;
                        }
                        
    
                        if ($Pairs[$j]->def !=null)
                        {
                            $defBlock = '<div id="de'.$d.'" class="blockcol defBlock defClickable d0">'.$Pairs[$j]->def.'</div>';
                            $defBlocks .= $defBlock;
                            $d++;
                        }
                    }
    
                    $theCode = '
                    <div id="TermToDefContainer" class="TTDmouseOverFig">
                        <div id="termPart" class="termPart col-sm-6 col-12">
                        ' . $termBlocks . '
                        </div>
    
                        <div id="defPart" class="defPart col-sm-6 col-12">
                        ' . $defBlocks . '
                        </div>
                    </div>';
                    break;
            }
        }
        
        $response = array("data"=>$theCode, "metadata"=>$metadata, "isEnd"=>$isEnd, "timer"=>$timer);
        echo json_encode($response);
    }
    
    public function quizInterfaceSQL1(Request $request, Subject $subject, Unit $unit, Lesson $quiz)
    {    
        $quizContent = array();
        $quizSeq = array();

        foreach($quiz->steps as $q){
            array_push($quizSeq, json_decode($q->id));
            array_push($quizContent, json_decode($q->content));
        }
        
        $StudentID = auth()->user()->id;
        // quiz code cancelled
        $QuestionNo = session('count')+1;
        $Answer = json_decode($request->Answer);
        $PrimaryKey = $StudentID.time(); // need to change
        $pass = 1;
    
        $timeSpent = time() - session('reqTime'); 
    
        $QuizType = $quizContent[session('count')]->Name;
    
        if ($Answer==null || $Answer=='null')
        {
            $InsTask = json_encode(null);
            $pass = 0;
        }
        else
        {
            switch ($QuizType) {
                case 'TestQuestion':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    for ($i=0; $i<count($Answer); $i++)
                    {
                        $check = true;
                        if (!in_array($Answer[$i], $Task->ans))
                        {
                            $check = false;
                            $pass = 0;
                        }
                        $Task->ans[$i]=array($Answer[$i], $check);
                    }
                    $NewTask = new Task('TestQuestion', $Task, $timeSpent);
                    break;
        
                case 'GroupSort':
                    $Task = $quizContent[session('count')]->TaskObj;     //array
                    usort($Task, function ($a, $b) {
                        return strcmp($a->group, $b->group);
                    });
                    usort($Answer, function ($a, $b) {
                        return strcmp($a->group, $b->group);
                    });
        
                    $StudAnsArr = array();
                    for ($j = 0; $j < count($Task); $j++)
                    {
                        $theItems = array();
                        foreach ($Answer[$j]->items as $item)
                        {
                            if (in_array($item, $Task[$j]->items))
                            {
                                $theItem = [$item, true];
                            }
                            else
                            {
                                $theItem = [$item, false];
                                $pass = 0;
                            }
                            array_push($theItems, $theItem);            //stopped somewhere here
                        }
                        $groupSortObj = new GroupSort($Answer[$j]->group, $theItems);
                        array_push($StudAnsArr, $groupSortObj);
                    }
                    $NewTask = new Task('GroupSort', $StudAnsArr, $timeSpent);
                    break;
        
                case 'PutInOrder':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    if ($Task->sentence != $Answer)
                    {
                        $pass = 0;
                        $Task->sentence = array($Answer, false);
                    }
                    else
                    {
                        $Task->sentence = array($Answer, true);
                    }            
                    
                    $NewTask = new Task('PutInOrder', $Task, $timeSpent);
                    break;
        
                case 'FillMissingWords':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $words = array();
                    for ($j=0; $j<count($Task->missedWords); $j++)
                    {
                        $correct = true;
                        if ($Answer[$j]!=$Task->missedWords[$j])
                        {
                            $correct = false;
                            $pass = 0;
                        }
                        array_push($words, array($Answer[$j], $correct));
                    }
                    $Task->missedWords = $words;
                    $NewTask = new Task('FillMissingWords', $Task, $timeSpent);
                    break;
        
                case 'TermToDef':
                    $Task = clone $quizContent[session('count')]->TaskObj;
                    $correctAns = $Task->paired + $Task->singleTerms + $Task->singleDefs;
                    $studAns = $Answer->paired + $Answer->singleTerms + $Answer->singleDefs;
                    usort($correctAns, function ($a, $b) {
                        return strcmp($a->term, $b->term);
                    });
                    usort($studAns, function ($a, $b) {
                        return strcmp($a->term, $b->term);
                    });
                    for ($j=0; $j<count($studAns); $j++)
                    {
                        if ($studAns[$j]->term!=$correctAns[$j]->term || $studAns[$j]->def!=$correctAns[$j]->def)
                        {
                            $pass = 0;
                            break;
                        }
                    }
        
                    $NewTask = new Task('TermToDef', $Answer, $timeSpent); 
                    break;
            }
        
            $InsTask = json_encode($NewTask);
        }
        
        //$query = "INSERT INTO answers VALUES ('$StudentID', '$QuizCode', '$QuestionNo', '$InsTask', '$PrimaryKey', '$pass')";


        try {
            $quiz = Step::find($quizSeq[session('count')]);
            $quiz->users()->attach($StudentID, ['result' => $pass,'created_at' => now()]);
            $tmp = session('count')+1;
            session(['count' => $tmp]);
            $response = array("data"=>$quizContent[session('count')-1], "metadata"=>"Success");
            return json_encode($response);
        } catch (\Exception $e) {
            $response = array("metadata"=>"Error! ".$e->getMessage());
            return json_encode($response);
        }
    }
    
    public function quizInterfaceSQL2(Subject $subject, Unit $unit, Lesson $quiz)
    {    
        $score = 0;

        foreach(auth()->user()->steps as $step){
            $score += $step->pivot->result;
        }
         
        return $score;
    }
    
    public function createquizSQL(Request $request, Subject $subject, Unit $unit)
    {    
        $lesson = new Lesson(['name' => $request->name, 'description' => $request->description, 'type' => 'quiz']);
        $unit->lessons()->save($lesson);
        $quizArr = json_decode($request->content);

        //[{"Name":"TestQuestion","TaskObj":{"quest":"jgfchkvbjkn","opts":["gfhvjbkn","ghvjbn"],"ans":["ghvjbn"]},"Timer":"15"},{"Name":"TestQuestion","TaskObj":{"quest":"gfhvjbgcfh","opts":["ghfcvjhfc","gfjcjhcgf"],"ans":["gfjcjhcgf"]},"Timer":"15"},{"Name":"FillMissingWords","TaskObj":{"completeText":"hgfcjgfc hgf hgf hhhh hgfhgfhgf","missedWords":["hgf","hhhh"],"incompleteText":"hgfcjgfc _____ hgf _____ hgfhgfhgf"},"Timer":"15"}]
        foreach($quizArr as $quiz){
            $step = new Step(['name' => 'Question', 'type' => $quiz->Name, 'content' => json_encode($quiz), 'max' => 1]);
            $lesson->steps()->save($step);
        }

        if($step)
            return "Success!";
        else
            return ("Error!");
    }
}
