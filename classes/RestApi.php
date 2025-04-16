<?php

namespace Ashraful\Bookium\Classes;

use Ashraful\Bookium\Classes\Core\Route;

class RestApi
{
    private static $instance;

    private function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function register()
    {
        require_once BOOKIUM_DIR_PATH . 'routes/api.php';
        Route::register();
    }
}
