<?php

namespace App\Support\Exceptions\HttpException;

use Exception;
use App\Support\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ForbiddenException extends BaseException
{
    public function __construct($message = '', array $headers = [], Exception $previous = null)
    {
        if (empty($message)) {
            $message = "You don't have permissions to perform this request.";
        }

        parent::__construct(HttpResponse::HTTP_FORBIDDEN, 'Forbidden', $message, $previous, $headers);
    }
}
