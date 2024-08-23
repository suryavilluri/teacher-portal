<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $teacher = Teacher::where('email', $request->email)->first();

        $credentials = $request->only('email', 'password');

        if (Auth::guard('teacher')->attempt($credentials)) {

            // store session
            $request->session()->put('teacher_id', $teacher->id);
            $request->session()->put('teacher_name', $teacher->name);
            $request->session()->put('teacher_email', $teacher->email);

            return redirect()->route('teacher.home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('teacher')->logout();
        $request->session()->forget('teacher_data');
        return redirect('/');
    }
}
