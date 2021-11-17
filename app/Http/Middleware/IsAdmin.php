<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\ReturnTrait;

class IsAdmin
{
    use ReturnTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if($request->user()->role != '1'){

            if($request->ajax()){
                return $this->error('Anda tidak memiliki hak akses');
            }

            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses');
        }

        return $next($request);
    }
}
