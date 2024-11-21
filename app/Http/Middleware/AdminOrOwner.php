<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->role === 'admin') {
            // Allow access if the user is an admin
            return $next($request);
        }

        // Check if the user is the owner of the resource by matching the user ID in the route parameters
        if ($user->id == $request->route('id')) {
            return $next($request);
        }

        // Deny access if neither condition is met
        return redirect('/login');
    }
}
