<?php
/**
 * The file responsible for starting the Like Button For Wordpress plugin
 *
 * The Like Button For Wordpress is a plugin that displays the post meta data
 * associated with a given post. This particular file is responsible for
 * including the necessary dependencies and starting the plugin.
 *
 * @package LBFW
 *
 * @wordpress-plugin
 * Plugin Name:       Like Button For Wordpress
 * Plugin URI:        http://wordpress.org/extend/plugins/
 * Description:       Adds 'like' button functionality to your WP site.
 * Version:           1.0.0
 * Text Domain:       like-button-for-wordpress
 * Domain Path:       /languages
 * Author:            A Brown
 * License:           The MIT License (MIT)
 * License URI:       https://opensource.org/licenses/MIT
 * Copyright:         Crown Copyright (c) 2018 Ministry of Justice
 */

 /*
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.

*/

// Exit if file is accessed directly.
if (! defined('ABSPATH')) {
    die();
}
/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-like-button-for-wordpress-manager.php';

/**
 * Instantiates the run Like Button For Wordpress class and then
 * calls its run method officially starting up the plugin.
 */
  function run_like_button_for_wordpress()
  {
      $lbfw = new Like_Button_For_Wordpress_Manager();
      $lbfw->run();
  }

// Call the above function to begin execution of the plugin.
run_like_button_for_wordpress();
