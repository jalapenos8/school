<?php

namespace App\Providers;

use App\Models\Subject;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('subject', function (Subject $subject) { // if user can change this exact subject
            return $subject->users->contains(auth()->user()->id);
        });
        Schema::defaultStringLength(125);
    }
}
