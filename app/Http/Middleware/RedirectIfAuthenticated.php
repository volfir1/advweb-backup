<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
       if(Auth::check()){
            if(auth::user()->is_admin){
                return redirect('/admin/dashboard');
            }else if(Auth::user()->is_customer){
                return redirect('/customer/dashboard');
            }else{
                return redirect('/');
            }
       }
       return $next($request);
    }
}
