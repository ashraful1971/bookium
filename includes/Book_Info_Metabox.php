<?php

namespace Ashraful\Bookium;

class Book_Info_Metabox
{
    private static $instance;

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [$this, 'save']);
    }

    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function add()
    {
        add_meta_box(
            'book_metabox',
            'Book Info',
            [$this, 'html'],
            array('book')
        );
    }

    public function html($post)
    {
        $published_date = get_post_meta($post->ID, 'published_date', true);
        $current_rating = get_post_meta($post->ID, 'rating', true) ;

        $options = '';
        $max_rating = 5;

        for ($rating = 1; $rating <= $max_rating; $rating++) {
            $options .= '<option value="' . $rating . '"' . selected($current_rating, $rating, false) . '>' . $rating . '</option>';
        }

?>
        <div>
            <div>
                <label for="published_date">Published Date</label>
                <input type="date" name="published_date" id="published_date" value="<?php echo esc_attr($published_date) ?>" class="form-input-tip" />
            </div>

            <div>
                <label for="rating">Rating</label>
                <select name="rating" id="rating" class="form-input-tip">
                    <option value="">Select rating...</option>
                    <?php echo wp_kses($options, ['option' => ['value' =>[], 'selected' => []]]);?>
                </select>
            </div>
        </div>
<?php
    }

    public function save($post_id)
    {
        if (array_key_exists('published_date', $_POST)) {
            update_post_meta(
                $post_id,
                'published_date',
                $_POST['published_date']
            );
        }

        if (array_key_exists('rating', $_POST)) {
            update_post_meta(
                $post_id,
                'rating',
                $_POST['rating']
            );
        }
    }
}
