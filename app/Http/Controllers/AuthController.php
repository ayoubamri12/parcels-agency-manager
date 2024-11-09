<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function create()
    {
        return view('login');
    }
    public function store(Request $request)
    {

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            Session::put('id', auth()->user()->id);
            return redirect()->route('deliverymen')->with('success', 'Logged in successfully!');
        }

        return back()->with(
            'error' ,'The provided credentials do not match our records.',
        );
    }
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
