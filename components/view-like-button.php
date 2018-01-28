<?php
/**
 * Displays the view for the Like Button For Wordpress .
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * view class that is used to display the html for the like button.
 *
 * @package LBFW
 */

$post_id = get_the_ID();

if(!metadata_exists('post',$post_id, 'lbfw_likes_count')) {
  add_post_meta( $post_id, 'lbfw_likes_count', 0);
}

?>
<?php

$posts = array_key_exists('like-button-for-wordpress-plugin', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin'] : [];

if (is_string($_COOKIE['like-button-for-wordpress-plugin'])) {
    $posts = unserialize($posts);
}

if(!array_key_exists($post_id, $posts)) {

  $result = '<div class="like-button-container">';
  $result .= '<h3><a href="#"><span id="like-icon"></span></a><h3>';
  $result .= '</div>';

  echo $result;

} else {

  $result = '<div class="like-button-container">';
  $result .= '<h3><span id="like-icon"></span><h3>';
  $result .= '</div>';

  echo $result;
}

?>
