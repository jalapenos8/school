<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string', 'size:12', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'year' => ['nullable', 'integer', 'max:2099', 'min:2000'],
            'grade' => ['nullable', 'char'],
            'img_path' => ['nullable', 'string', 'max:1024'],
        ]);

        $user = User::create([
            'id' => $request->id,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'surname' => $request->surname,
            'email' => $request->email,
            'year' => $request->year,
            'grade' => $request->grade,
            'position' => $request->position,
            'img_path' => $request->img_path,
            'password' => Hash::make("password"), // need to make with email confirmation and random password
        ]);

        $user->assignRole($request->input('role'));

        event(new Registered($user));

        return redirect()->route('register');
    }
}
