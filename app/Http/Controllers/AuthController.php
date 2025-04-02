<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        $roles = Role::where('selectable', true)->get();

        return view('auth.register', [
            'roles' => $roles,
        ]);
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|exists:roles,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        auth()->login($user);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials, $request->remember)) {
            session()->flash('error', 'The provided credentials do not match our records.');

            return redirect()->back();
        }

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
