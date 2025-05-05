<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            redirect(route('news-stories.index'));
        } else {
            return Inertia::render('Auth/Signin');
        }
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:50'
        ]);

        if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))) {
            $request->session()->regenerate();

            return redirect(route('news-stories.index'));
        }

        throw ValidationException::withMessages(['password' => 'Password or email not match, or account not active']);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect(route('auth.login'));
    }
}
