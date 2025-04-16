<?php

namespace Ashraful\Bookium\Contracts;

interface Request
{
    public function get_method();
    public function get_route();
    public function get_headers();
    public function all();
    public function except(array $attributes);
    public function only(string $key);
    public function input(string $key);
}
