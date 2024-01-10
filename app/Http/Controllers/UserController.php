<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $incomingRequest = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($incomingRequest)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'error' => 'Invalid email or password',
        ]);
    }

    public function register(Request $request)
    {
        $incomingRequest = $request->validate([
            'registerName' => ['required', 'max:255'],
            'registerEmail' => ['required', 'email', 'unique:users,email'],
            'registerPassword' => ['required', 'min:8'],
        ]);
        $incomingRequest['registerPassword'] = bcrypt($incomingRequest['registerPassword']);

        $user = User::create([
            'name' => $incomingRequest['registerName'],
            'email' => $incomingRequest['registerEmail'],
            'password' => $incomingRequest['registerPassword'],
        ]);
        auth()->login($user);

        return redirect('/');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
