<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function create()
    {
        return view('login.login');
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
    public function updatePassword(Request $request, $id) {
        $user = User::where('delivery_id',$id)->get();
        $user[0]->password = Hash::make($request->password);
        $user[0]->save();
        return response()->json(['message' => 'Password updated successfully']);
    }
    
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
