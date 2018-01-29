<?php
/**
 * Displays the view for the Like Button For Wordpress .
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * view class that is used to display the html for the like button.
 *
 * @package LBFW
 */

if (!metadata_exists('post', get_the_ID(), 'lbfw_likes_count')) {
    add_post_meta(get_the_ID(), 'lbfw_likes_count', 0);
}

function like_button_run($post_id, $posts)
{
    $post_id = get_the_ID();

    $posts = array_key_exists('like-button-for-wordpress-plugin', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin'] : [];

    if (is_string($_COOKIE['like-button-for-wordpress-plugin'])) {
        $posts = unserialize($posts);
    }

    if (!array_key_exists($post_id, $posts)) {
        $result = '<div class="like-button-container">';
        $result .= '<a href="#"><span id="like-icon"></span></a>';
        $result .= '</div>';

        echo $result;
    } else {
        $result = '<div class="like-button-container">';
        $result .= '<span id="like-icon"></span>';
        $result .= '</div>';

        echo $result;
    }
}
