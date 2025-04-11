<?php

namespace Ashraful\Bookium;

class Bookium
{
    private static $instance;

    private function __construct()
    {
        $this->init();
    }

    /**
     * Get the instance
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Initialize the core functionalities
     */
    public function init()
    {
        Book_Post_Type::init();
        Book_Taxonomies::init();
        Book_Info_Metabox::init();
        Book_Api::init();
    }
}
