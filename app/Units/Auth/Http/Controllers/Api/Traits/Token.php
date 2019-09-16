<?php

namespace App\Units\Auth\Http\Controllers\Api\Traits;

use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait Token
{
    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param int|null $statusCode
     * @param array|null $optionalData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token, int $statusCode = null, ...$optionalData): JsonResponse
    {
        /** @var \Tymon\JWTAuth\Token|string */
        $newToken = auth('api')->setToken($token);

        /** @var \Tymon\JWTAuth\Payload */
        $payload = $newToken->payload();
        // $payload = $this->guard()->payload($token);

        /* Additional payload data */
        $payloadableUser = [
            'name' => $payload->get('name'),
            'email' => $payload->get('email'),
            // 'is_super_admin' => $payload->get('is_super_admin') ?? false,
        ];

        /** @var \App\Units\Auth\User */
        // Get the currently authenticated user
        // Authenticated user
        $user = $newToken->user();
        $user->loadMissing('company');

        $payloadableUser['name'] = $user->name;
        $payloadableUser['email'] = $user->email;

        if ($user->relationLoaded('company') && ! empty($user->getRelation('company'))) {
            $payloadableUser['company_key'] = $payload->get('company_key');
        }

        // all good so return the token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'created_at' => date('d/m/Y H:i:s', $payload->get('iat')),
            'not_before_at' => date('d/m/Y H:i:s', $payload->get('nbf')),
            'expires_at' => date('d/m/Y H:i:s', $payload->get('exp')),
            // 'expires_in' => auth('api')->factory()->getTTL() * 60,
            // 'id' => $payload->get('sub'), // = users.id
            'user' => $payloadableUser,
            'data' => $optionalData ?? null
        ], $statusCode ?? HttpResponse::HTTP_OK);
    }
}
