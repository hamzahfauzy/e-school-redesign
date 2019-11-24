<?php

namespace App\Http\Middleware;

use Closure;

class CheckSchool
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
        if(!auth()->user()->school || count(auth()->user()->school) == 0 && !auth()->user()->isRole('admin') && !auth()->user()->isRole('admin_sistem_informasi'))
            return redirect()->route('step',1);
        
        return $next($request);
    }
}
