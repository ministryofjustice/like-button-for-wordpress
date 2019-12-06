<?php

/**
 * The Like Button For Wordpress Admin defines all functionality for the dashboard
 * of the plugin
 *
 * @package LBFW
 */

/**
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since 1.0.0
 */

 // Exit if file is accessed directly.
 if (! defined('ABSPATH')) {
     die();
 }

class Like_Button_For_Wordpress_Admin
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
              'like-button-for-wordpress-admin',
              plugin_dir_url(__FILE__) . 'css/like-button-for-wordpress-admin.css',
              array(),
              $this->version,
              false
          );
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with the current post.
     */
    public function like_button_for_wordpress_menu()
    {
      /**
       * Add submenu page takes 7 variables, $parent_slug, $page_title,
       * $menu_title, $capability, $menu_slug, $function and $position
       * https://developer.wordpress.org/reference/functions/add_submenu_page/
       */
        add_submenu_page(
              'options-general.php',
              'Like Button For Wordpress',
              'Like Button For WP',
              'administrator',
              'like-button-for-wordpress-admin-page',
              [$this, 'render_like_button_admin_page'],
              10
          );
    }

    /**
     * Requires the file that is used to display the admin interface page.
     */
    public function render_like_button_admin_page()
    {
        require_once plugin_dir_path(__FILE__) . 'view-admin-settings-page.php';
    }
}
