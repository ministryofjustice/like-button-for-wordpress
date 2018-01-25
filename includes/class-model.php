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
          wp_localize_script('like-button-for-wordpress', 'LikeButtonData',
              [
                'currentPostID' => get_the_ID(),
                'likeButtonCount'  => get_post_meta(get_the_ID(), 'lbfw_likes_count'),
                'adminAjaxWP'  => admin_url('admin-ajax.php')

              ]
            );
    }

    public function like_button_ajax_update_db()
    {
        // Post values returning from AJAX request
        $post_id = $_POST['postID'];
        $like_count_value = $_POST['likeCountValue'];

        $like_count_value = $like_count_value + 1;

        update_post_meta($post_id, 'lbfw_likes_count', $like_count_value);

        wp_die();
    }


    /**
     * Loads the Like Button on any WP single page.
     */
    public function like_button_for_wordpress_view($content)
    {
        if (is_single()) {
            echo '<div id="blog-post-103">';
            echo $content;
            require_once plugin_dir_path(__FILE__) . '../components/view-like-button.php';
            echo '</div>';
        } else {
            return $content;
        }
    }
}
