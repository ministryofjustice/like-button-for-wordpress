<?php

/**
 * The Like Button For Wordpress view.
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

class Like_Button_For_Wordpress_View
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
     * Enqueues the stylesheet responsible for styling the contents of the plugin on the site.
     * The plugin uses minimal styling to allow developers and designers maximum control over design.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
              'like-button-for-wordpress-view',
              plugin_dir_url(__FILE__) . 'css/like-button-for-wordpress-view.css',
              array(),
              $this->version,
              false
          );
    }

    /**
     * Loads the Like Button on any WP single page.
     */
    public function like_button_for_wordpress_view()
    {
        if (is_single()) {
            require_once plugin_dir_path(__FILE__) . '../partial/like-button-for-wordpress-view.php';
        }
        return;
    }
}
