<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required']
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Check if user is actually an admin
            if (!auth()->user()->is_admin) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'phone' => 'ليس لديك صلاحية للدخول إلى لوحة التحكم.',
                ])->onlyInput('phone');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'phone' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('phone');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
