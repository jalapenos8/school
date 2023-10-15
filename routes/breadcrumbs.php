<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Step;
use App\Models\User;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Subject
Breadcrumbs::for('subjects.show', function (BreadcrumbTrail $trail, Subject $subject) {
    $trail->push($subject->name, route('subjects.show', [$subject]));
});

// Dashboard > Subject > edit
Breadcrumbs::for('subjects.edit', function (BreadcrumbTrail $trail, Subject $subject) {
    $trail->parent('subjects.show', $subject);
    $trail->push('Edit', route('subjects.edit', [$subject]));
});

// Dashboard > Subject > Unit
Breadcrumbs::for('units.show', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit) {
    $trail->parent('subjects.show', $subject);
    $trail->push($unit->name, route('units.show', [$subject, $unit]));
});

// Dashboard > Subject > Unit > edit
Breadcrumbs::for('units.edit', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit) {
    $trail->parent('units.show', $subject, $unit);
    $trail->push('Edit', route('units.edit', [$subject, $unit]));
});

// Dashboard > Subject > Unit > Lesson or Quiz
Breadcrumbs::for('lessons.show', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit, Lesson $lesson) {
    $trail->parent('units.show', $subject, $unit);
    $trail->push($lesson->name, route('lessons.show', [$subject, $unit, $lesson]));
});

// Dashboard > Subject > Unit > Lesson > edit
Breadcrumbs::for('lessons.edit', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit, Lesson $lesson) {
    $trail->parent('lessons.show', $subject, $unit, $lesson);
    $trail->push('Edit', route('lessons.edit', [$subject, $unit, $lesson]));
});

// Dashboard > Subject > Unit > create lesson
Breadcrumbs::for('lessons.create', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit) {
    $trail->parent('units.show', $subject, $unit);
    $trail->push("Новый урок", route('lessons.create', [$subject, $unit]));
});

// Dashboard > Subject > Unit > create quiz
Breadcrumbs::for('quizzes.create', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit) {
    $trail->parent('units.show', $subject, $unit);
    $trail->push("Новый quiz", route('quizzes.create', [$subject, $unit]));
});

// Dashboard > Subject > Unit > Lesson > Step
Breadcrumbs::for('steps.show', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit, Lesson $lesson, Step $step) {
    $trail->parent('lessons.show', $subject, $unit, $lesson);
    $trail->push($step->name, route('steps.show', [$subject, $unit, $lesson, $step]));
});

// Dashboard > Subject > Unit > Lesson > Step > edit
Breadcrumbs::for('steps.edit', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit, Lesson $lesson, Step $step) {
    $trail->parent('steps.show', $subject, $unit, $lesson, $step);
    $trail->push('Edit', route('steps.edit', [$subject, $unit, $lesson, $step]));
});

// Dashboard > Subject > Unit > Lesson > create step
Breadcrumbs::for('steps.create', function (BreadcrumbTrail $trail, Subject $subject, Unit $unit, Lesson $lesson) {
    $trail->parent('lessons.show', $subject, $unit, $lesson);
    $trail->push("Новый шаг", route('steps.create', [$subject, $unit, $lesson]));
});

