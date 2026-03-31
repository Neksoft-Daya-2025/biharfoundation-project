<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('admin_logged_in') || Session::get('admin_logged_in') !== true) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized. Please login.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $loginTime = Session::get('admin_login_time');
        if ($loginTime && (now()->timestamp - $loginTime) > (24 * 60 * 60)) {
            Session::forget('admin_logged_in');
            Session::forget('admin_login_time');

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Session expired. Please login again.'], 401);
            }
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        return $next($request);
    }
}
