<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->status === 'Inactive') {
            // Log the user out and clear the session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Return an error response with a link to the login page
            return response()->make(
                '<html>
                    <body style="font-family: Arial, sans-serif; text-align: center; padding: 50px;">
                        <h1 style="color: red;">Account Inactive</h1>
                        <p>Your account is inactive. Please contact support if this problem persists.</p>
                        <a href="' . route('admin.login') . '"
                           style="padding: 10px 20px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;">
                            Back to Login
                        </a>
                    </body>
                </html>',
                403 // HTTP Forbidden
            );
        }

        return $next($request);
    }
}
