<?php

/**
 * The Like Button For Wordpress model. This page collects and manages the data generated
 * by the like button and then pushes that data to the component view displaying the like button and counter.
 *
 * @package LBFW
 */

/**
 *
 *
 * @since 1.0.0
 */

// Exit if file is accessed directly.
if (!defined('ABSPATH')) {
    die();
}

/**
 * Returns the liked IDs stored in a like-button cookie, as a list of unique positive integers.
 *
 * The cookie holds a JSON list of IDs, e.g. [12,45]. It is visitor-controlled, so it is
 * decoded with json_decode (which never instantiates PHP objects) and anything that is not
 * a positive integer ID is discarded. A missing or malformed cookie yields [].
 *
 * @param string $cookie_name The name of the cookie to read.
 * @return int[] Liked IDs.
 */
function lbfw_get_liked_ids($cookie_name)
{
    if (!isset($_COOKIE[$cookie_name]) || !is_string($_COOKIE[$cookie_name])) {
        return [];
    }

    // WordPress adds slashes to $_COOKIE.
    $raw = wp_unslash($_COOKIE[$cookie_name]);

    if ('' === $raw || strlen($raw) > 4096) {
        return [];
    }

    // Limit nesting; any non-integer entries are discarded below.
    $data = json_decode($raw, true, 2);

    if (!is_array($data)) {
        return [];
    }

    $ids = array_filter($data, fn($id) => is_int($id) && $id > 0);

    return array_values(array_unique($ids));
}

class Like_Button_For_Wordpress_Model
{

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @access private
     * @var string $version The current version of the plugin.
     */
    private string $version;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct(string $version)
    {
        $this->version = $version;

        require_once plugin_dir_path(__FILE__) . '../components/view-like-button.php';
    }

    /**
     * Enqueues Javascript into WP. Responsible for styling the contents of the plugin on the site.
     * Enqueues the stylesheet into WP. Responsible for styling the contents of the plugin on the site.
     * Enqueue scripts relating to the admin area of wp can be found in the /admin section of the plugin.
     */
    public function enqueue_scripts()
    {
        $handle = 'like-button-for-wordpress';
        $src = plugin_dir_url(__FILE__) . '../assets';

        wp_enqueue_script($handle, $src . '/js/' . $handle. '.js', [], $this->version, true);
        wp_enqueue_style($handle, $src . '/css/' . $handle. '.css', [], $this->version);

        // Passes WP/PHP data to the enqueued Javascript file
        wp_localize_script(
            $handle,
            'LikeButtonData',
            [
                'currentPostID' => get_the_ID(),
                'likeNonce' => wp_create_nonce('like_button_nonce'),
                'likeButtonCount' => get_post_meta(get_the_ID(), 'lbfw_likes', true),
                'adminAjaxWP' => admin_url('admin-ajax.php')
            ]
        );
    }

    public function like_button_ajax_update()
    {
        check_ajax_referer('like_button_nonce', 'security');

        // Values returned from AJAX (like-button-for-wordpress.js).
        // IDs must be positive integers and like counts must be integers. A field may be absent
        // (a post like sends no comment fields and vice versa), but a non-integer value is rejected.
        $post_id = $this->get_int_from_post('postID', 1);
        $like_count_value = $this->get_int_from_post('likeCountValue');
        $comment_id = $this->get_int_from_post('commentID', 1);
        $like_comment_count_value = $this->get_int_from_post('likeCommentCountValue');

        // Which cookie to set: 1 = post like, 2 = comment like. Absent means no cookie is set.
        $cookie_validation = $this->get_int_from_post('cookie');

        if (false === $post_id || false === $like_count_value || false === $comment_id || false === $like_comment_count_value || false === $cookie_validation) {
            wp_send_json_error(['message' => 'Invalid input: IDs, like counts and cookie must be integers.'], 400);
        }

        // Update the database
        if (null !== $post_id && null !== $like_count_value) {
            update_post_meta($post_id, 'lbfw_likes', $like_count_value);
        }

        if (null !== $comment_id && null !== $like_comment_count_value) {
            update_comment_meta($comment_id, 'lbfw_likes', $like_comment_count_value);
        }

        // Validates that there has been a like button click
        switch ($cookie_validation) {
            case 1:
                $this->set_cookie_value('like-button-for-wordpress-plugin', $post_id);
                break;
            case 2:
                $this->set_cookie_value('like-button-for-wordpress-plugin-comments', $comment_id);
        }

        wp_die();
    }

    public function set_cookie_value($key, $id)
    {
        // No valid ID was sent, so there is nothing to record.
        if (!$id) {
            return;
        }

        // Set array of post IDs in the cookie
        $object_ids = lbfw_get_liked_ids($key);

        if (!in_array((int) $id, $object_ids, true)) {
            $object_ids[] = (int) $id;
        }

        // Cookie set to six months
        setcookie($key, wp_json_encode($object_ids), time() + 86400 * 180, '/');
    }

    /**
     * Reads an integer value from $_POST.
     *
     * @param string   $key The $_POST key to read.
     * @param int|null $min Optional minimum allowed value.
     * @return int|null|false The integer when valid, null when the key is absent or empty,
     *                        or false when a value is present but is not a valid integer.
     */
    private function get_int_from_post($key, $min = null)
    {
        if (!isset($_POST[$key]) || '' === $_POST[$key]) {
            return null;
        }

        if (!is_scalar($_POST[$key])) {
            return false;
        }

        $options = (null === $min) ? [] : ['options' => ['min_range' => $min]];

        return filter_var(wp_unslash($_POST[$key]), FILTER_VALIDATE_INT, $options);
    }

    /**
     * Loads the Like Button on any WP single page. Implement in future versions.
     */
    // public function like_button_for_wordpress_view($content)
    // {
    //     if (is_single()) {
    //         echo '<div id="blog-post-103">';
    //         echo $content;
    //         require_once plugin_dir_path(__FILE__) . '../components/view-like-button.php';
    //         echo '</div>';
    //     } else {
    //         return $content;
    //     }
    // }
}
