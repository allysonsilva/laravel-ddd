<?php

namespace App\Units\Auth\Http\Controllers\Api\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait Respond
{
    /**
     * The HTTP response headers.
     *
     * @var array
     */
    protected $respondHeaders = [];

    /**
     * The HTTP response meta data.
     *
     * @var array
     */
    protected $respondMeta = [];

    /**
     * The HTTP response data.
     *
     * @var mixed
     */
    protected $respondData = [];

    /**
     * The HTTP response status code.
     *
     * @var int
     */
    protected $respondStatusCode = HttpResponse::HTTP_OK;

    protected function addHeadersInResponse(array $headers): self
    {
        $this->respondHeaders = $headers;

        return $this;
    }

    protected function setRespondMeta(array $meta): self
    {
        $this->respondMeta = $meta;

        return $this;
    }

    protected function setRespondData(array $data): self
    {
        $this->respondData = $data;

        return $this;
    }

    protected function setRespondStatusCode(int $statusCode): self
    {
        $this->respondStatusCode = $statusCode;

        return $this;
    }

    /**
     * Build the response for standard.
     *
     * @param string $type
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondStandard(string $type, string $message, int $statusCode = HttpResponse::HTTP_OK): JsonResponse
    {
        return $this
                ->setRespondData([
                    'type' => $type,
                    'message' => $message
                ])
                ->setRespondStatusCode($statusCode)
                ->respond();
    }

    /**
     * Build the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond(): JsonResponse
    {
        $response = [];

        if (! empty($this->respondMeta)) {
            $response['meta'] = $this->respondMeta;
        }

        $response['data'] = $this->respondData;

        if ($this->respondData instanceof Arrayable) {
            $response['data'] = $this->respondData->toArray();
        }

        return response()->json($response, $this->respondStatusCode, $this->respondHeaders);
    }
}
