<?php

namespace Ashraful\Bookium\Classes\Core;

use Ashraful\Bookium\Contracts\Request as BaseRequest;
use WP_REST_Request;

class Request implements BaseRequest
{
    private array $attributes = [];
    private string $method;
    private string $route;
    private array $headers;

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public static function from_wp_rest_request(WP_REST_Request $request)
    {
        $instance = new self();

        $instance->attributes = array_merge($instance->attributes, $request->get_params());
        $instance->method = $request->get_method();
        $instance->route = $request->get_route();
        $instance->headers = $request->get_headers();

        return $instance;
    }

    public function get_method()
    {
        return $this->method;
    }

    public function get_route()
    {
        return $this->route;
    }

    public function get_headers()
    {
        return $this->headers;
    }

    public function all()
    {
        return $this->attributes;
    }

    public function except(array $attributes)
    {
        return array_diff_key($this->attributes, array_flip($attributes));
    }

    public function only(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function input(string $key)
    {
        return $this->only($key);
    }
}
