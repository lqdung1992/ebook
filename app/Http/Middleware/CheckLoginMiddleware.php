<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckLoginMiddleware
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
        
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->role == 0){
                return $next($request);
            }else{
                return redirect('admin');
            }
        }else return redirect('admin')->with('thongbao','Bạn không có quyền truy cập');
    }
}
