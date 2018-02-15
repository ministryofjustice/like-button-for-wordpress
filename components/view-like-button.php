<?php
/**
 * Displays the view for the Like Button For Wordpress .
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * view class that is used to display the html for the like button.
 *
 * @package LBFW
 */

// Function directly called by shortcode.
function like_button_run()
{

    // Checks WP database, if post meta doesn't exist add a new entry into the database.
    if (!metadata_exists('post', get_the_ID(), 'lbfw_likes_count')) {
        add_post_meta(get_the_ID(), 'lbfw_likes_count', 0);
    }

    // Checks WP database, if comment meta doesn't exist add a new entry into the database.
    if (!metadata_exists('comment', get_comment_ID(), 'lbfw_likes_comment_count')) {
        add_comment_meta(get_comment_ID(), 'lbfw_likes_comment_count', 0);
    }

    /**
    * Check the set cookie and return it's contents.
    */
    $posts = array_key_exists('like-button-for-wordpress-plugin', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin'] : [];
    $comments = array_key_exists('like-button-for-wordpress-plugin-comments', $_COOKIE) ? (string) $_COOKIE['like-button-for-wordpress-plugin-comments'] : [];

    $post_id = get_the_ID();
    $comment_id = get_comment_ID();
    // Return like count from database (WP Post Meta)
    $db_like_count = get_post_meta(get_the_ID(), 'lbfw_likes_count', true);
    $comment_count = get_comment_meta(get_comment_ID(), 'lbfw_likes_comment_count', true);

    if (empty($db_like_count)) {
        $db_like_count = 0;
    }

    if (empty($comment_count)) {
        $comment_count = 0;
    }

    // Required to format the cookie's array correctly into the post ID.
    if (is_string($_COOKIE['like-button-for-wordpress-plugin'])) {
        $posts = unserialize($posts);
    }

    // Required to format the cookie's array correctly into the post ID.
    if (is_string($_COOKIE['like-button-for-wordpress-plugin-comments'])) {
        $comments = unserialize($comments);
    }

    // Returns a like button in two forms, depending on whether the user has clicked on it or not.
    if (empty($comment_id)) {
        // If the post id does not appear in the browser cookie display one result, if it is display another.
        if (!array_key_exists($post_id, $posts)) {
            $result = '<div class="like-button-container">';
            $result .= '<button class="like-button-count" id="post-like-button"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $db_like_count . '</span>' . '</button>';
            $result .= '</div>';

            echo $result;
        } else {
            $result = '<div class="like-button-container">';
            $result .= '<span class="like-button-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $db_like_count . '</span>' . '</span>';
            $result .= '</div>';

            echo $result;
        }
    }

    if (!empty($comment_id)) {
        if (!array_key_exists($comment_id, $comments)) {
            $result = '<div class="like-button-container-comments" data-comment-like-count='. $comment_count .' data-comment-id='. $comment_id .'>';
            $result .= '<button class="like-button-comment-count"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $comment_count . '</span>' . '</button>';
            $result .= '</div>';

            echo $result;
        } else {
            $result = '<div class="comment_vote_off">';
            $result .= '<span class="like-button-comment-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . $comment_count . '</span>' . '</span>';
            $result .= '</div>';

            echo $result;
        }
    }
}
