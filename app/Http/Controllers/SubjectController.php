<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function dashboard()
    {
        $subjects = Subject::all();// add some DB querries

        foreach($subjects as $subject){        
            $count = DB::table('steps')
                ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                ->join('units', 'lessons.unit_id', '=', 'units.id')
                ->join('subjects', 'units.subject_id', '=', 'subjects.id')
                ->select('steps.*')
                ->where('subjects.id', '=', $subject->id)
                ->get()->count();
                
            $count2 = DB::table('step_user')
                ->join('users', 'step_user.user_id', '=', 'users.id')
                ->join('steps', 'step_user.step_id', '=', 'steps.id')
                ->join('lessons', 'steps.lesson_id', '=', 'lessons.id')
                ->join('units', 'lessons.unit_id', '=', 'units.id')
                ->join('subjects', 'units.subject_id', '=', 'subjects.id')
                ->select('step_user.*')
                ->where('step_user.user_id', '=', auth()->user()->id)
                ->where('subjects.id', '=', $subject->id)
                ->get()->count();
            
            if($count != 0)
                $subject->done = floor(($count2/$count)*100)."%";
            else 
                $subject->done = "0%";
        }
        
        return view('dashboard')->with(compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('admin')->get()->merge(User::role('teacher')->get());

        return view('subjects.create')->with(compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create([
            'name' => $request->name,
            'grade' => $request->grade,
            'img' => $request->img,
        ]);

        foreach($request->teachers as $id)
            $subject->users()->attach($id, ['created_at' => now()]);

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $units = $subject->units;
        return view('subjects.show')->with(compact(['subject', 'units']));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $users = User::role('admin')->get()->merge(User::role('teacher')->get());
        return view('subjects.edit')->with(compact(['subject', 'users']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->name = $request->name;
        $subject->img = $request->img;
        $subject->grade = $request->grade;

        $subject->users()->detach();

        foreach($request->teachers as $id)
            $subject->users()->attach($id, ['created_at' => now()]);

        $subject->save();

        return redirect(route('subjects.show', [$subject]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('dashboard');
    }
}
