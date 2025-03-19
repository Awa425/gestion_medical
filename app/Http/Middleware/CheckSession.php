<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convert minutes to seconds
            
            if (time() - $lastActivity > $sessionLifetime) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }
            
            Session::put('last_activity', time());
        }
        
        return $next($request); 
    }
}
