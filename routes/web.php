<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Subject;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [SubjectController::class, 'dashboard'])->name('dashboard');
    
    Route::middleware('can:subjects')->group(function ()
    {
        Route::resource('subjects', SubjectController::class)->except(['index', 'show', 'destroy']);
        Route::get('subjects/{subject}/delete', [SubjectController::class, 'destroy'])->name('subjects.delete');
    });

    Route::resource('subjects', SubjectController::class)->only(['show']);

    Route::middleware('subject')->group(function () // can change this particular subject
    {
        Route::prefix('subjects/{subject}')->group(function(){
            Route::resource('units', UnitController::class)->only(['store', 'edit', 'update']);

            Route::prefix('units/{unit}')->group(function(){
                Route::post('/change', [UnitController::class, 'change'])->name('units.change');
                Route::get('/delete', [UnitController::class, 'destroy'])->name('units.delete');

                Route::resource('/lessons', LessonController::class)->only(['create','store', 'edit', 'update']);
                Route::prefix('/quizzes')->group(function(){
                    Route::get('/create', [QuizController::class, 'create'])->name('quizzes.create');
                    Route::post('/createquizSQL', [QuizController::class, 'createquizSQL'])->name('quizzes.createSQL');
                });

                Route::prefix('/lessons/{lesson}')->group(function(){
                    Route::get('/delete', [LessonController::class, 'destroy'])->name('lessons.delete');
                    Route::resource('/steps', StepController::class)->only(['create','store', 'edit', 'update']);
                    Route::get('/steps/{step}/delete', [StepController::class, 'destroy'])->name('steps.delete');
                });
            });
        });
    });


    Route::prefix('subjects/{subject}')->group(function(){
        Route::resource('units', UnitController::class)->only(['show']);
        Route::prefix('units/{unit}')->group(function(){
            Route::resource('/lessons', LessonController::class)->only(['show']);

            Route::prefix('/quizzes/{quiz}')->group(function(){
                Route::get('/', [QuizController::class, 'show'])->name('quizzes.show');
                Route::get('/quizInterfaceSQL', [QuizController::class, 'quizInterfaceSQL'])->name('quizzes.interfaceSQL');
                Route::post('/quizInterfaceSQL1', [QuizController::class, 'quizInterfaceSQL1'])->name('quizzes.interfaceSQL1');
                Route::get('/quizInterfaceSQL2', [QuizController::class, 'quizInterfaceSQL2'])->name('quizzes.interfaceSQL2');
            });
            
            Route::prefix('/lessons/{lesson}')->group(function(){
                Route::resource('/steps', StepController::class)->only(['show']);
                Route::post('steps/{step}/submit', [StepController::class, 'submit'])->name('steps.submit');
            });
        });
    });

    Route::get('/results', [UnitController::class, 'results'])->name('results');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
