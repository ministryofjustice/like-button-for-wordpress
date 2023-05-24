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

        // Values returned from AJAX (like-button-for-wordpress.js)
        $post_id = sanitize_text_field($_POST['postID'] ?? null);
        $like_count_value = sanitize_text_field($_POST['likeCountValue'] ?? null);
        $comment_id = sanitize_text_field($_POST['commentID'] ?? null);
        $like_comment_count_value = sanitize_text_field($_POST['likeCommentCountValue'] ?? null);

        // Update the database
        update_post_meta($post_id, 'lbfw_likes', $like_count_value);
        update_comment_meta($comment_id, 'lbfw_likes', $like_comment_count_value);

        // Validates that there has been a like button click
        switch (sanitize_text_field($_POST['cookie'])) {
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
        // Set array of post IDs in the cookie
        $object_ids = $_COOKIE[$key] ?? [];

        if (is_string($object_ids)) {
            $object_ids = unserialize($object_ids);
        }

        $object_ids[] = (int)$id;

        // Cookie set to six months
        setcookie($key, htmlspecialchars(serialize($object_ids), ENT_QUOTES), time() + 86400 * 180, '/');
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
