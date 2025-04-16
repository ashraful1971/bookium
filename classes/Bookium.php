<?php

namespace Ashraful\Bookium\Classes;

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
        BookPostType::init();
        BookTaxonomies::init();
        BookInfoMetabox::init();
        RestApi::init();
    }
}
