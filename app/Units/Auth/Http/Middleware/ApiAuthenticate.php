<?php

namespace App\Units\Auth\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiAuthenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, bool $authenticateAndRenew = false)
    {
        // if ($request->header('Authorization') === 'XYZ') {
        //     return $next($request);
        // }

        $this->checkForToken($request);

        try {

            $user = $this->auth->parseToken()->authenticate();

        } catch (TokenExpiredException $e) {
            throw new UnauthorizedHttpException('auth.api', trans('TOKEN_EXPIRED'), $e);
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('auth.api', $e->getMessage(), $e, $e->getCode());
        }

        if (! $user) {
            throw new NotFoundHttpException(trans('USER_NOT_FOUND'));
        }

        if ($authenticateAndRenew) {
            $response = $next($request);

            // Send the refreshed token back to the client
            return $this->setAuthenticationHeader($response);
        }

        return $next($request);
    }

    /**
     * Check the request for the presence of a token.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return void
     */
    public function checkForToken(Request $request)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            throw new AccessDeniedHttpException(trans('TOKEN_NOT_PROVIDED'));
        }
    }

    /**
     * Set the authentication header.
     *
     * @param  \Illuminate\Http\Response|\Illuminate\Http\JsonResponse  $response
     * @param  string|null  $token
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function setAuthenticationHeader($response, $token = null)
    {
        try {

            $newToken = $token ?: $this->auth->refresh();

        } catch (TokenExpiredException $e) {
            throw new UnauthorizedHttpException('auth.api', trans('TOKEN_EXPIRED'), $e);
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('auth.api', $e->getMessage(), $e, $e->getCode());
        }

        $response->headers->set('Authorization', 'Bearer '.$newToken);

        return $response;
    }
}
