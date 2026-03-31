<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Session::has('admin_logged_in') && Session::get('admin_logged_in') === true) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            Session::put('admin_logged_in', true);
            Session::put('admin_login_time', now()->timestamp);

            return redirect()->intended(route('dashboard'))->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::forget('admin_logged_in');
        Session::forget('admin_login_time');

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
