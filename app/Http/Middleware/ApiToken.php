<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
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
        $token = 'MWcFiQSFjAr1Ij98ZyT69rmS7IkjLbR4Hq7u2a3YH22dZ10ZanslKtE1Z2ob1vCy';
        if($request->token != $token)
             return response('Bad request.', 400);

        return $next($request);
    }
}
