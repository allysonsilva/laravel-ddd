<?php

namespace App\Units\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\Exceptions\HttpException\ForbiddenException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if ($request->user()->hasRole($roles)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            //TODO:
        }

        throw new ForbiddenException();
    }
}
