<?php

namespace Ashraful\Bookium\Contracts;

interface Response
{
    public static function json(array|string $data);
}
