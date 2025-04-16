<?php

namespace Ashraful\Bookium\Classes\Core;

use Ashraful\Bookium\App\Exceptions\InvalidRoutActionException;

class Route
{
    private static $namespace = '';
    private static $routes = [];

    public static function set_namespace(string $namespace)
    {
        self::$namespace = $namespace;
    }

    public static function get(string $endpoint, string|array|callable $action, string|null $middleware = null)
    {
        self::$routes['get'][] = [
            'endpoint' => $endpoint,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public static function post(string $endpoint, string|array|callable $action, string|null $middleware = null)
    {
        self::$routes['post'][] = [
            'endpoint' => $endpoint,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public static function put(string $endpoint, string|array|callable $action, string|null $middleware = null)
    {
        self::$routes['put'][] = [
            'endpoint' => $endpoint,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public static function delete(string $endpoint, string|array|callable $action, string|null $middleware = null)
    {
        self::$routes['delete'][] = [
            'endpoint' => $endpoint,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public static function get_routes()
    {
        return self::$routes;
    }

    public static function register()
    {
        foreach (self::$routes as $method => $routes) {
            foreach ($routes as $route) {
                register_rest_route(self::$namespace, $route['endpoint'], [
                    'methods' => strtoupper($method),
                    'callback' => self::resolve_action($route['action']),
                    'permission_callback' => self::resolve_middleware($route['middleware'])
                ]);
            }
        }
    }

    private static function resolve_action(string|array|callable $action)
    {
        return function($restRequest) use($action){
            $request = Request::from_wp_rest_request($restRequest);

            if (is_array($action) && count($action) === 2) {
                return (new $action[0])->$action[1]($request);
            }

            if (is_string($action) && class_exists($action)) {
                return (new $action())($request);
            }

            if (is_callable($action)) {
                return $action($request);
            }

            throw new InvalidRoutActionException("Invalid action/callback in routes.");
        };
    }
    
    private static function resolve_middleware(?string $middleware)
    {
        return function($restRequest) use($middleware){
            $request = Request::from_wp_rest_request($restRequest);

            return $middleware ? (new $middleware)->handle($request) : true;
        };
    }
}
