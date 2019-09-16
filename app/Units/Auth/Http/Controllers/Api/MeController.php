<?php

namespace App\Units\Auth\Http\Controllers\Api;

use Exception;
use App\Units\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Units\Auth\Http\Resources\UserResource;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Units\Auth\Http\Controllers\Api\Controller as BaseController;

class MeController extends BaseController
{
    /** @var \Illuminate\Http\Request */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(): JsonResponse
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->respondStandard('USER_NOT_FOUND', 'Nenhum usuário pôde ser encontrado.', HttpResponse::HTTP_NOT_FOUND);
            }

        } catch (TokenExpiredException $exception) {
            return $this->respondStandard('TOKEN_EXPIRED', 'Token expirado.', HttpResponse::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $exception) {
            return $this->respondStandard('TOKEN_INVALID', 'Token inválido.', HttpResponse::HTTP_BAD_REQUEST);
        } catch (JWTException $exception) {
            return $this->respondStandard('TOKEN_ABSENT', 'Algo deu errado ao validar o token.', HttpResponse::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            return $this->respondStandard('ERROR_USER_PROFILE', 'Algo deu errado ao tentar validar o token.', HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return (new UserResource($user))->response();
    }

    /**
     * Updates user profile logged in
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        /** @var \Illuminate\Database\Eloquent\Model */
        $user = auth('api')->setRequest($request)->user();

        $this->validateUpdate($request, $user);

        $optionalData = [];

        if ($request->has('password')) {

            $this->validate($request, [
                'password' => 'bail|required|confirmed|min:6|max:255',
                'password_confirmation' => 'bail|required|same:password',
            ]);

            $optionalData['password'] = bcrypt($request->password);
        }

        $dataUser = array_merge($optionalData, $request->only('name', 'email'));

        /** Fill the model with an array of attributes. */
        $user->fill($dataUser);

        if ($user->update()) {
            return $this->respondStandard('UPDATED_USER', 'Perfil atualizado com sucesso.', HttpResponse::HTTP_OK);
        }

        return $this->respondStandard('ERROR_UPDATE_USER', 'Não foi possíve atualizar o perfil, verifique os dados e tente novamente.', HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Validate the user update request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Units\Auth\User $user
     *
     * @return void
     */
    private function validateUpdate(Request $request, User $user): void
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => "bail|required|email|unique:users,email,{$user->getKey()}",
        ]);
    }
}
