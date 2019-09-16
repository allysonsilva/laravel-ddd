<?php

namespace App\Units\Auth\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Units\Auth\Http\Controllers\Api\Traits\{
    Token,
    Respond
};
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        Token,
        Respond;
}
