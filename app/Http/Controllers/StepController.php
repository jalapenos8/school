<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\Objective;
use App\Models\Step;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStepRequest;
use App\Http\Requests\UpdateStepRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subject $subject, Unit $unit, Lesson $lesson)
    {
        return view('steps.create')->with(compact(['subject','lesson','unit']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subject $subject, Unit $unit, Lesson $lesson)
    {
        if($request->type == 'file'){
            $uploadedFile = $request->file('content');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('files', $filename, ['disk' => 'public']);
            $step = new Step(['name' => $request->name,'type' => $request->type,'content' => $path]);
        } else {
            $step = new Step(['name' => $request->name,'type' => $request->type,'content' => $request->content]);
        }

        $lesson->steps()->save($step);

        return redirect(route('steps.show', [$subject, $unit, $lesson, $step]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Unit $unit, Lesson $lesson, Step $step)
    {
        $lessons = $unit->lessons;
        $steps = $unit->steps;
        if($step->type == 'whiteboard')
            return redirect()->intended('http://localhost:8080/?whiteboardid='.$step->id.'&username='.(Auth::user()->name).'&title='.$step->name);
        return view('steps.show')->with(compact(['subject', 'lesson','unit','step','lessons','steps']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Unit $unit, Lesson $lesson, Step $step)
    {
        return view('steps.edit')->with(compact(['subject', 'unit', 'lesson', 'step']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStepRequest $request, Subject $subject, Unit $unit, Lesson $lesson, Step $step)
    {
        if($request->type == 'file'){
            $uploadedFile = $request->file('content');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('files', $filename, ['disk' => 'public']);
            $step->name = $request->name;
            $step->content = $path;
        } else {
            $step->name = $request->name;
            $step->content = $request->content;
        }

        $step->save();

        return redirect(route('steps.show', [$subject, $unit, $lesson, $step]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Unit $unit, Lesson $lesson, Step $step)
    {
        $step->delete();

        return redirect()->route('lessons.show', [$subject, $unit, $lesson]);
    }

    /**
     * Submit test
     */
    public function submit(Request $request, Subject $subject, Unit $unit, Lesson $lesson, Step $step)
    {
        //$test = json_decode($step->content, true);
        //$count = 0;
        //$all = count($test['option_1']);
        //for($i = 1;$i <= $all;$i++){
        //    if($_POST['option_'.$i] == $test['option_'.$test['answer_'.$i]][$i-1]){
        //        $count++;
        //    }
        //}

        $user = $request->user();

        if(!$step->users->contains($user)){
            $user->steps()->attach($step, ['result' => 1, 'created_at' => now()]);
        }  
        $next_step = $lesson->nextStep($step);
        if($next_step != null)
            return redirect()->route('steps.show', [$subject, $unit, $lesson, $next_step->id]);
        else
            return redirect()->route('steps.show', [$subject, $unit, $lesson, $step]);
    }
}
