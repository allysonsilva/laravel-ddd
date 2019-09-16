<?php

namespace App\Core\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RedirectIfAuthenticated
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * Create a new Middleware instance.
     *
     * @param \Tymon\JWTAuth\JWTAuth  $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if ($this->isGuardApi($guard)) {
                if (! empty(optional($this->auth->setRequest($request)->getToken())->get())) {
                    throw new UnauthorizedHttpException('auth.api', trans('Action can not be performed!'));
                }
            }

            return redirect()->route('dashboard.index')->with('error', 'Recurso pode ser acessado somente por visitantes!');
        }

        return $next($request);
    }

    private function isGuardApi($guard = null): bool
    {
        return ! empty($guard) && $guard === 'api';
    }
}
