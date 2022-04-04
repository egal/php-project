<?php

namespace Egal\Core\Http;

use Closure;
use Egal\Core\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticateMiddleware
{

    public function handle(Request $request, Closure $next): mixed
    {
        Auth::authenticate($request->header('Authorization'));

        return $next($request);
    }

}
