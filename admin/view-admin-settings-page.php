<?php
/**
 * Displays the admin interface for the Like Button For Wordpress.
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * Admin class that is used to display all of the settings and plugin information related
 * to using and administrating the like plugin.
 *
 * @package LBFW
 */

 // Exit if file is accessed directly.
 if (! defined('ABSPATH')) {
     die();
 }

$plugin_version = $this->version;
?>

<h1>Like Button For Wordpress Settings</h1>
<div class="wrap">

  <div class="card card-primary">
    <p>You can add the like button on your post or comment in two ways. Either via adding the PHP code or using the shortcode. Add the Like Button to your site's code use:</p>
    <pre>&lt;?php echo do_shortcode('[likebutton]'); ?&gt;</pre>
    <p>For best results this should be placed within the WP loop somewhere under the body text of the page. For comments, place within the individual comment block of code.</p>
    <p>Or</p>
    <p>Copy and paste shortcode into your post:</p>
    <pre>[likebutton]</pre>
  </div>

  <div class="card card-secondary">
    <ul>
      <li><h1>Plugin details</h1></li>
      <li>Plugin Name: Like Button For Wordpress</li>
      <li>Plugin URI: <a href="https://github.com/ministryofjustice/like-button-for-wordpress"> https://github.com/ministryofjustice/like-button-for-wordpress</a></li>
      <li>Description: Adds 'like' button functionality to your WP site.</li>
      <li><?php echo "Version: " . $plugin_version; ?></li>
      <li>Text Domain: like-button-for-wordpress</li>
      <li>Domain Path: /languages</li>
      <li>Author: A Brown</li>
      <li>License: The MIT License (MIT)</li>
      <li>License URI: https://opensource.org/licenses/MIT</li>
      <li>Copyright: Crown Copyright (c) 2018 Ministry of Justice</li>
    </ul>
  </div>

</div>
<div class="clear"></div>
