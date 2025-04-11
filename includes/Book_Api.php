<?php

namespace Ashraful\Bookium;

class Book_Api
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
        register_rest_route('books', '/all', array(
            'methods' => 'GET',
            'permission_callback' => [$this, 'middleware'],
            'callback' => [$this, 'index'],
        ));
    }

    public function middleware($request)
    {
        return $request->get_params()['token'] == 'secret';
    }

    public function index()
    {
        $posts = get_posts([
            'post_type' => 'book',
            'post_status' => 'publish',
            'numberposts' => -1,
            'order'    => 'ASC'
        ]);

        $restult = [];

        foreach($posts as $post){
            $post->author_name = wp_kses(get_the_term_list( $post->ID, 'author', '', ', ' ), []);
            $post->rating = get_post_meta($post->ID, 'rating', true);
        }

        return $posts;
    }
}
