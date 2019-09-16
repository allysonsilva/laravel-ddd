<?php

namespace App\Support\Exceptions\HttpException;

use Exception;
use App\Support\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UnauthorizedException extends BaseException
{
    public function __construct($message = '', array $headers = [], Exception $previous = null)
    {
        parent::__construct(HttpResponse::HTTP_UNAUTHORIZED, 'Unauthorized', $message, $previous, $headers);
    }
}
