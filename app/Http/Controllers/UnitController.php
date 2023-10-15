<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request, Subject $subject)
    {
        $unit = new Unit([
            'name' => $request->name,
            'term' => $request->term,
        ]);

        $subject->units()->save($unit);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Unit $unit)
    {
        if($unit->status == 'awaiting' && !$subject->users->contains(auth()->user()->id))
            return back();
        $lessons = $unit->lessons;
        $steps = $unit->steps;
        return view('units.show')->with(compact(['subject', 'unit', 'lessons','steps']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Unit $unit)
    {
        return view('units.edit')->with(compact(['subject', 'unit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Subject $subject, Unit $unit)
    {
        $unit->name = $request->name;
        $unit->term = $request->term;

        $unit->save();

        return redirect(route('units.show', [$subject, $unit]));
    }

    /**
     * change status of the specified resource in storage.
     */
    public function change(Request $request, Subject $subject, Unit $unit)
    {
        $unit->status = (($unit->status == 'awaiting') ? 'published' : 'awaiting');
        $unit->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Unit $unit)
    {
        $unit->delete();

        return redirect()->route('subjects.show', [$subject]);
    }

    public function results()
    {
        $subjects = Subject::all();// add some DB querries

        foreach($subjects as $subject){        
            $count = DB::table('steps') // count all steps of subject
                ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                ->join('units', 'lessons.unit_id', '=', 'units.id')
                ->join('subjects', 'units.subject_id', '=', 'subjects.id')
                ->select('steps.*')
                ->where('subjects.id', '=', $subject->id)
                ->get()->count();
                
            $count2 = DB::table('step_user') // count steps which are done by user
                ->join('users', 'step_user.user_id', '=', 'users.id')
                ->join('steps', 'step_user.step_id', '=', 'steps.id')
                ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                ->join('units', 'lessons.unit_id', '=', 'units.id')
                ->join('subjects', 'units.subject_id', '=', 'subjects.id')
                ->select('step_user.*')
                ->where('step_user.user_id', '=', auth()->user()->id)
                ->where('subjects.id', '=', $subject->id)
                ->get()->count();

            $subject->stepsHas = $count;
            $subject->stepsDone = $count2;
            
            if($subject->stepsDone != 0 && $subject->stepsHas != 0){
                foreach($subject->units as $unit) {            
                    $count = DB::table('steps') // count all steps of subject
                        ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                        ->join('units', 'lessons.unit_id', '=', 'units.id')
                        ->select('steps.*')
                        ->where('units.id', '=', $unit->id)
                        ->get()->count();

                    $count2 = DB::table('step_user') // count steps which are done by user
                        ->join('users', 'step_user.user_id', '=', 'users.id')
                        ->join('steps', 'step_user.step_id', '=', 'steps.id')
                        ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                        ->join('units', 'lessons.unit_id', '=', 'units.id')
                        ->select('step_user.*')
                        ->where('step_user.user_id', '=', auth()->user()->id)
                        ->where('units.id', '=', $unit->id)
                        ->get()->count();

                    $unit->stepsHas = $count;
                    $unit->stepsDone = $count2;

                    foreach($unit->lessons as $lesson) {            
                        $count = DB::table('steps') // count all steps of subject
                            ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                            ->select('steps.*')
                            ->where('lessons.id', '=', $lesson->id)
                            ->get()->count();
    
                        $count2 = DB::table('step_user') // count steps which are done by user
                            ->join('users', 'step_user.user_id', '=', 'users.id')
                            ->join('steps', 'step_user.step_id', '=', 'steps.id')
                            ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                            ->select('step_user.*')
                            ->where('step_user.user_id', '=', auth()->user()->id)
                            ->where('lessons.id', '=', $lesson->id)
                            ->get()->count();
    
                        $lesson->stepsHas = $count;
                        $lesson->stepsDone = $count2;
                    }
                }
            }
        }
        return view('units.results')->with(compact('subjects'));
    }
}
