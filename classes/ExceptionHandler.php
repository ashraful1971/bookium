<?php

namespace Ashraful\Bookium\Classes;

class ExceptionHandler
{
    private static $instance;

    private function __construct()
    {
        set_exception_handler([$this, 'handle']);
    }

    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function handle($exception)
    {
        if (defined('REST_REQUEST') && REST_REQUEST) {
            wp_send_json([
                'error' => $exception->getMessage(),
                'code' => 'internal_server_error',
            ], 500);
            exit;
        } else {
            echo 'An unexpected error occurred. Please try again later.';
            exit;
        }
    }
}
