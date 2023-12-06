<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is an admin
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        // If not an admin, redirect or show an error
        return redirect('/home')->withErrors(['error' => 'You do not have permission to access this page.']);
    }
}
