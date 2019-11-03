<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->status == 0)
        {
            Auth::logout();
            return redirect()->route('login')->with(['error' => 'Akun anda tidak aktif. Silahkan hubungi administrator terkait masalah ini.']);
        }
        return $next($request);
    }
}
