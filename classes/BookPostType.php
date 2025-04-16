<?php

namespace Ashraful\Bookium\Classes;

class BookPostType
{
    private static $instance;

    private function __construct()
    {
        add_action('init', [$this, 'register']);
        add_action('restrict_manage_posts', [$this, 'add_admin_filters'], 10, 1);
        add_action('parse_query', [$this, 'filter_books']);
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
        $labels = array(
            'name' => __('Books', 'bookium'),
            'singular_name' => __('Book', 'bookium'),
            'add_new' => __('New Book', 'bookium'),
            'add_new_item' => __('Add New Book', 'bookium'),
            'edit_item' => __('Edit Book', 'bookium'),
            'new_item' => __('New Book', 'bookium'),
            'view_item' => __('View Book', 'bookium'),
            'search_items' => __('Search Books', 'bookium'),
            'not_found' =>  __('No Books Found', 'bookium'),
            'not_found_in_trash' => __('No Books found in Trash', 'bookium'),
        );
        $args = array(
            'labels' => $labels,
            'has_archive' => true,
            'public' => true,
            'hierarchical' => false,
            'rewrite' => array('slug' => 'books'),
            'supports' => array(
                'title',
                'thumbnail',
            ),
        );

        register_post_type('book', $args);
    }

    public function add_admin_filters($post_type)
    {
        if ('book' !== $post_type) {
            return;
        }
        $taxonomies_slugs = array('author', 'genre');
        foreach ($taxonomies_slugs as $slug) {
            $taxonomy = get_taxonomy($slug);
            $selected = isset($_REQUEST[$slug]) ? $_REQUEST[$slug] : '';
            wp_dropdown_categories(array(
                'show_option_all' => $taxonomy->labels->all_items,
                'taxonomy'        => $slug,
                'name'            => $slug . '_filter',
                'orderby'         => 'name',
                'value_field'     => 'slug',
                'selected'        => $selected,
                'hierarchical'    => true,
            ));
        }

        echo '<select name="rating_filter" id="rating_filter">';
        echo '<option value="">Select Rating</option>';

        // Loop through each term and display as options in the dropdown
        $max_rating = 5;
        for ($rating = 1; $rating <= $max_rating; $rating++) {
            echo '<option value="' . $rating . '"' . selected($_GET['rating_filter'], $rating, false) . '>' . $rating . '</option>';
        }

        echo '</select>';
    }

    function filter_books($query)
    {
        global $pagenow;

        if (is_admin() && $pagenow === 'edit.php' && isset($_GET['author' . '_filter']) && $_GET['author' . '_filter'] != 0) {
            $query->query_vars['tax_query'][] = array(
                array(
                    'taxonomy'  => 'author',
                    'field'     => 'slug',
                    'terms'     => $_GET['author' . '_filter']
                )
            );
        }

        if (is_admin() && $pagenow === 'edit.php' && isset($_GET['genre' . '_filter']) && $_GET['genre' . '_filter'] != 0) {
            $query->query_vars['tax_query'][] = array(
                array(
                    'taxonomy'  => 'genre',
                    'field'     => 'slug',
                    'terms'     => $_GET['genre' . '_filter']
                )
            );
        }

        if (is_admin() && $pagenow === 'edit.php' && isset($_GET['rating' . '_filter']) && $_GET['rating' . '_filter'] != 0) {
            $query->query_vars['meta_query'][] = array(
                array(
                    'key'  => 'rating',
                    'value'     => $_GET['rating' . '_filter']
                )
            );
        }
    }
}
