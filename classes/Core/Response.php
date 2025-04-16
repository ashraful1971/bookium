<?php

namespace Ashraful\Bookium\Classes\Core;

use Ashraful\Bookium\Contracts\Response as BaseResponse;
use WP_REST_Response;

class Response implements BaseResponse
{
    const OK = 200;
    const CREATED = 201;

    public static function json(array|string $data, int $code =  200)
    {
        return new WP_REST_Response($data, $code);
    }
}
