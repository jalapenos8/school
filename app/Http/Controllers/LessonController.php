<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\Step;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use PhpParser\Node\Expr\Cast\Object_;

class LessonController extends Controller
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
    public function create(Subject $subject, Unit $unit)
    {
        return view('lessons.create')->with(compact(['subject','unit']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Subject $subject, Unit $unit)
    {
        $lesson = new Lesson(['name' => $request->name]);

        $unit->lessons()->save($lesson);

        $unit->refresh();

        return redirect(route('lessons.show', [$subject, $unit, $lesson]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject, Unit $unit, Lesson $lesson)
    {
        $lessons = $unit->lessons;
        $steps = $unit->steps;
        if($lesson->type == 'lesson')
            return view('lessons.show')->with(compact(['subject','unit', 'lessons','steps', 'lesson']));
        else if($lesson->type == 'quiz')
            return redirect()->route('quizzes.show', [$subject, $unit, $lesson]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject, Unit $unit, Lesson $lesson)
    {
        return view('lessons.edit')->with(compact(['subject', 'unit', 'lesson']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Subject $subject, Unit $unit, Lesson $lesson)
    {
        if($lesson->type == 'quiz')
            return redirect(route('quizzes.edit', [$lesson]));
        $lesson->name = $request->name;
        $lesson->description = $request->description;

        $lesson->save();

        return redirect(route('lessons.show', [$subject, $unit, $lesson]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject, Unit $unit, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('units.show', [$subject, $unit]);
    }
}
