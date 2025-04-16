<?php

namespace Ashraful\Bookium\Classes;

class BookTaxonomies
{
    private static $instance;

    private function __construct()
    {
        add_action('init', [$this, 'register']);
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
        $this->register_author_taxonomy();
        $this->register_genre_taxonomy();
    }

    public function register_author_taxonomy()
    {

        $labels = array(
            'name'              => __('Authors', 'bookium'),
            'singular_name'     => __('Author', 'bookium'),
            'search_items'      => __('Search Authors', 'bookium'),
            'all_items'         => __('All Authors', 'bookium'),
            'edit_item'         => __('Edit Authors', 'bookium'),
            'update_item'       => __('Update Authors', 'bookium'),
            'add_new_item'      => __('Add New Authors', 'bookium'),
            'new_item_name'     => __('New Author Name', 'bookium'),
            'menu_name'         => __('Authors', 'bookium'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'sort' => true,
            'args' => array('orderby' => 'term_order'),
            'rewrite' => array('slug' => 'authors'),
            'show_admin_column' => true
        );

        register_taxonomy('author', array('book'), $args);
    }

    public function register_genre_taxonomy()
    {

        $labels = array(
            'name'              => __('Genres', 'bookium'),
            'singular_name'     => __('Author', 'bookium'),
            'search_items'      => __('Search Genres', 'bookium'),
            'all_items'         => __('All Genres', 'bookium'),
            'edit_item'         => __('Edit Genres', 'bookium'),
            'update_item'       => __('Update Genres', 'bookium'),
            'add_new_item'      => __('Add New Genres', 'bookium'),
            'new_item_name'     => __('New Author Name', 'bookium'),
            'menu_name'         => __('Genres', 'bookium'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'sort' => true,
            'args' => array('orderby' => 'term_order'),
            'rewrite' => array('slug' => 'genres'),
            'show_admin_column' => true
        );

        register_taxonomy('genre', array('book'), $args);
    }
}
