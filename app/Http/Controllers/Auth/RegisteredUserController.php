<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('role.selection');
    }

        /**
     * Display the role selection view.
     */
    public function showRoleSelection(): Response
    {
        $teachers = User::whereHas('role', function($query) {
            $query->where('name', 'teacher');
        })->get();

        return Inertia::render('Auth/RoleSelection', [
            'teachers' => $teachers,
        ]);
    }

        /**
     * Handle an incoming role selection request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handleRoleSelection(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $user = Auth::user();

        $role = Role::create([
            'name' => $request->role,
            'user_id' => $user->id,
        ]);

        $user->role_id = $role->id;
        if ($request->role === 'student') {
            $user->teacher_id = $request->teacher_id;
        }

        $user->save();

        if ($request->role === 'teacher') {
            return redirect()->route('student.dashboard');
        } elseif ($request->role === 'student') {
            return redirect()->route('student.dashboard');
        } else {
            return redirect()->route('dashboard');
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
