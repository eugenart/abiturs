<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $username)
    {
        $userid = User::where('name', $username)->first();
        if (auth()->user() ) {
            if (auth()->user()->id != $userid->id) {
                abort(404);
            }
        }else{
            abort(404);
        }
        return $next($request);
    }
}
