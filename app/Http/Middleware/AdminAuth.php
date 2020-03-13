<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
{
    
    protected $except = [
        'admin/login',
        'admin/logout'
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->path(), $this->except)) {
            if (!\App\Facades\AdminLogin::isLoggedIn()) {
                return redirect('/admin/login');
            }
        }
        return $next($request);
    }
}
