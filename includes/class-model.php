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
 if (! defined('ABSPATH')) {
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
    private $version;
    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
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
        wp_enqueue_script(
              'like-button-for-wordpress',
              plugin_dir_url(__FILE__) . '../assets/js/like-button-for-wordpress.js',
              array(),
              $this->version,
              true
          );

        wp_enqueue_style(
              'like-button-for-wordpress',
              plugin_dir_url(__FILE__) . '../assets/css/like-button-for-wordpress.css',
              array(),
              $this->version,
              false
          );

        // Passes WP/PHP data to the enqueued Javascript file
        wp_localize_script(
              'like-button-for-wordpress',
              'LikeButtonData',
              [
                'currentPostID' => get_the_ID(),
                'likeNonce' => wp_create_nonce('like_button_nonce'),
                'likeButtonCount'  => get_post_meta(get_the_ID(), 'lbfw_likes', true),
                'adminAjaxWP'  => admin_url('admin-ajax.php')
              ]
            );
    }

    public function like_button_ajax_update()
    {
        $likeNonce = check_ajax_referer('like_button_nonce', 'security');

        // Values returned from AJAX (like-button-for-wordpress.js)
        $post_id = isset($_POST['postID']) ? sanitize_text_field($_POST['postID']): null;
        $like_count_value = isset($_POST['likeCountValue']) ? sanitize_text_field($_POST['likeCountValue']): null;
        $comment_id = isset($_POST['commentID']) ? sanitize_text_field($_POST['commentID']): null;
        $like_comment_count_value = isset($_POST['likeCommentCountValue']) ? sanitize_text_field($_POST['likeCommentCountValue']): null;

        // Update the database
        update_post_meta($post_id, 'lbfw_likes', $like_count_value);
        update_comment_meta($comment_id, 'lbfw_likes', $like_comment_count_value);

        // Validates that there has been a like button click
        $cookie_validation = sanitize_text_field($_POST['cookie']);

        if ($cookie_validation == 1) {
            // Set array of post IDs in the cookie
            $posts = array_key_exists('like-button-for-wordpress-plugin', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin'] : [];

            if (is_string($_COOKIE['like-button-for-wordpress-plugin'])) {
                $posts = unserialize($posts);
            }

            $posts[$post_id] = null;
            // Cookie set to six months
            setcookie('like-button-for-wordpress-plugin', serialize($posts), time() + 86400 * 180, '/', "", false, true);
        }

        if ($cookie_validation == 2) {
            // Set array of post IDs in the cookie
            $comments = array_key_exists('like-button-for-wordpress-plugin-comments', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin-comments'] : [];

            if (is_string($_COOKIE['like-button-for-wordpress-plugin-comments'])) {
                $comments = unserialize($comments);
            }

            $comments[$comment_id] = null;
            // Cookie set to six months
            setcookie('like-button-for-wordpress-plugin-comments', serialize($comments), time() + 86400 * 180, '/', "", false, true);
        }

        wp_die();
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
