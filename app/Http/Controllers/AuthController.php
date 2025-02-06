<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view("register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1',
            'email' => 'required|email',
            'password' => 'required|min:6|',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        auth()->login($user);

        return redirect()->route('login');
    }

    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view("login");
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'remember' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
