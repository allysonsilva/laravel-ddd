<?php

namespace App\Support\Exceptions\HttpException;

use Exception;
use App\Support\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UnprocessableEntityException extends BaseException
{
    public function __construct($message = '', array $headers = [], Exception $previous = null)
    {
        parent::__construct(HttpResponse::HTTP_UNPROCESSABLE_ENTITY, 'Unprocessable Entity', $message, $previous, $headers);
    }
}
