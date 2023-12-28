<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->Admin == 1) {
            return $next($request);
        }

        // If the user is not an admin, redirect them to the home page
        return redirect('home');
    }
}
?>
