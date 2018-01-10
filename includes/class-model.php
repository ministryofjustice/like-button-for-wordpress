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
     * Loads the Like Button on any WP single page.
     */
    public function like_button_for_wordpress_view($content)
    {
        if (is_single()) {
            echo $content;
            require_once plugin_dir_path(__FILE__) . '../components/view-like-button.php';
        } else {
            return $content;
        }
    }
}
