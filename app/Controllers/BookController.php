<?php

namespace Ashraful\Bookium\App\Controllers;

use Ashraful\Bookium\Contracts\Request;
use Ashraful\Bookium\Classes\Core\Response;

class BookController {
    public function __invoke(Request $request)
    {
        // var_dump($request->all());
        $posts = get_posts([
            'post_type' => 'book',
            'post_status' => 'publish',
            'numberposts' => -1,
            'order'    => 'ASC'
        ]);

        foreach($posts as $post){
            $post->author_name = wp_kses(get_the_term_list( $post->ID, 'author', '', ', ' ), []);
            $post->rating = get_post_meta($post->ID, 'rating', true);
        }

        return Response::json($posts, Response::OK);
    }
}