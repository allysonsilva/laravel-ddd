<?php

namespace App\Units\Auth\Http\Controllers\Api;

use Throwable;
use App\Units\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use App\Units\Auth\Services\UpdateUserLastLogin;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Units\Auth\Http\Controllers\Api\Controller as BaseController;

class AuthController extends BaseController
{
    /** @var \App\Units\Auth\User */
    private $user;

    /** @var \Illuminate\Http\Request */
    private $request;

    /**
     * Create a new Controller instance.
     *
     * @param \App\Units\Auth\User $user
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;

        $this->middleware('guest:api')->only('login');
    }

    /**
     * Handle a login request to the application.
     *
     * Get a JWT via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function login(Request $request): JsonResponse
    {
        $this->validateLogin($request);

        try {

            if ($token = $this->attemptLogin($request)) {
                return $this->sendLoginResponse($request, $token);
            }

            return $this->respondStandard('INVALID_CREDENTIALS', 'Credenciais informadas não correspondem com nossos registros.', HttpResponse::HTTP_UNAUTHORIZED);

        } catch (JWTException $jwtException) {

            // something went wrong whilst attempting to encode the token
            return $this->respondStandard('COULD_NOT_CREATE_TOKEN', 'Algo deu errado ao tentar criar o token de autenticação.', HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Throwable $exception) {
            throw $exception;
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string|bool
     */
    private function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // attempt to verify the credentials and create a token for the user
        // verify the credentials and create a token for the user
        return $token = auth('api')->attempt($credentials);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     *
     * @return \Illuminate\Http\Response
     */
    private function sendLoginResponse(Request $request, string $token)
    {
        app(UpdateUserLastLogin::class, ['user' => auth('api')->user()])->execute();

        return $this->respondWithToken($token);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([trans('auth.failed')]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        if (! $token = JWTAuth::getToken()) {
            return $this->respondStandard('TOKEN_NOT_PROVIDED', 'Token não informado.', HttpResponse::HTTP_UNAUTHORIZED);
        }

        try {

            auth('api')->logout(true);

        } catch (JWTException $e) {
            return $this->respondStandard('TOKEN_ABSENT', 'Algo deu errado ao validar o token.', HttpResponse::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $this->respondStandard('COULD_NOT_LOGOUT_USER', 'Token informado não pôde ser adicionado a lista negra(Blacklist). Token inválido.', HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondStandard('LOGOUT_OK', 'Successfully logged out.', HttpResponse::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        try {

            // Refresh an expired token
            /** @var string */
            $token = auth('api')->refresh(true, true);

        } catch (TokenExpiredException $exception) {
            return $this->respondStandard('TOKEN_EXPIRED', 'Token expirado.', HttpResponse::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $exception) {
            return $this->respondStandard('TOKEN_INVALID', 'Token inválido.', HttpResponse::HTTP_BAD_REQUEST);
        } catch (JWTException $exception) {
            return $this->respondStandard('TOKEN_ABSENT', 'Algo deu errado ao validar o token.', HttpResponse::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return $this->respondStandard('COULD_NOT_REFRESH_TOKEN', 'Token não pôde ser atualizado. Erro ao atualizar token.', HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function credentials(Request $request): array
    {
        return array_merge($request->only($this->username(), $this->password()), ['is_enabled' => true]);
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateLogin(Request $request): void
    {
        $usernameColumn = $this->username();
        $passwordColumn = $this->password();

        $this->validate($request, [
            $usernameColumn => [
                'bail',
                'required',
                'email',
                'string',
                Rule::exists($this->user->getTable(), $usernameColumn),
            ],
            $passwordColumn => 'bail|required|min:6',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    private function username(): string
    {
        return 'email';
    }

    /**
     * Get the login password to be used by the controller.
     *
     * @return string
     */
    private function password(): string
    {
        return 'password';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }
}
