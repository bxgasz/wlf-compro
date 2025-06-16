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
        if (Auth::guard('web')->check()) {
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

        if (Auth::guard('web')->attempt(array('email' => $request->email, 'password' => $request->password))) {
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

    // grantee

    public function loginGrantee()
    {
        if (Auth::guard('grantee')->check()) {
            return redirect(route('grantee'));
        } else {
            return Inertia::render('Auth/SigninGrantee');
        }
    }

    public function authGrantee(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:50'
        ]);

        if (Auth::guard('grantee')->attempt(array('email' => $request->email, 'password' => $request->password))) {
            $request->session()->regenerate();

            return redirect(route('grantee'));
        }

        throw ValidationException::withMessages(['password' => 'Password or email not match, or account not active']);
    }

    public function destroyGrantee(Request $request)
    {
        Auth::guard('grantee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect(route('home'));
    }
}
