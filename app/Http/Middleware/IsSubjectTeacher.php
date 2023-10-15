<?php

namespace App\Http\Middleware;

use App\Models\Subject;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSubjectTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subject = $request->route('subject');
        
        if(!$subject->users->contains(auth()->user()->id)){
            return abort(403);
        }

        return $next($request);
    }
}
