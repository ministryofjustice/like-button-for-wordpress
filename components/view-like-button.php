<?php
/**
 * Displays the view for the Like Button For Wordpress .
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * view class that is used to display the html for the like button.
 *
 * @package LBFW
 */

// Checks WP database, if post meta doesn't exist add a new entry into the database.
if (!metadata_exists('post', get_the_ID(), 'lbfw_likes_count')) {
    add_post_meta(get_the_ID(), 'lbfw_likes_count', 0);
}

// Function directly called by shortcode.
function like_button_run()
{

    /**
    * Check the set cookie and return it's contents.
    */
    $posts = array_key_exists('like-button-for-wordpress-plugin', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin'] : [];
    $post_id = get_the_ID();

    // Return like count from database (WP Post Meta)
    $db_like_count = get_post_meta(get_the_ID(), 'lbfw_likes_count', true);

    if (empty($db_like_count)) {
        $db_like_count = 0;
    }

    // Required to format the cookie's array correctly into the post ID.
    if (is_string($_COOKIE['like-button-for-wordpress-plugin'])) {
        $posts = unserialize($posts);
    }

    // Returns a like button in two forms, depending on whether the user has clicked on it or not. There is also a function in the plugin JS that swaps this like button when it is clicked on. This mainly deals with on load and returning visits.
    if (!array_key_exists($post_id, $posts)) {
        $result = '<div class="like-button-container">';
        $result .= '<button class="like-button-count"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $db_like_count . '</span>' . '</button>';
        $result .= '</div>';

        echo $result;
    } else {
        $result = '<div class="like-button-container">';
        $result .= '<span class="like-button-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $db_like_count . '</span>' . '</span>';
        $result .= '</div>';

        echo $result;
    }
}
