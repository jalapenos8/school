<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Subject;

class Assigned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, Subject $subject): Response
    {
        dd($request->user()->subjects()->where('id', $subject)->get());
        if($request->user()->subjects()->where('id', $subject)->get())


        return $next($request);
    }
}
