<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isAdmin
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
         if (Auth::user() &&  Auth::user()->_id == '58fd6cc13fd89d8b529e4acf') {
                return $next($request);
         }
    
        return redirect('/');
    }
}
