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
    $meta_key = 'lbfw_likes';
    $cookie_key = 'like-button-for-wordpress-plugin';

    /**
     * Likes displayed on posts
     */
    if (!get_comment()) {
        $post_id = get_the_ID();
        $posts = lbfw_get_liked_ids($cookie_key);
        $db_like_count = get_post_meta($post_id, $meta_key, true) ?: 0;

        // Checks WP database, if post meta doesn't exist add a new entry into the database.
        metadata_exists('post', $post_id, $meta_key) ?: add_post_meta($post_id, $meta_key, 0);

        // Create an aria label string
        $like_count_text = ($db_like_count == 1
            ? $db_like_count . ' person liked this'
            : $db_like_count . ' people liked this');

        // Check if the post id is in the cookie. If it is then display without button so visitor can't click again.
        echo in_array((int) $post_id, $posts, true)
            ? '<div class="like-button-container"><span aria-label="' . esc_attr($like_count_text) . '" class="like-button-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . esc_html($db_like_count) . '</span>' . '</span></div>'
            : '<div class="like-button-container"><button aria-label="' . esc_attr($like_count_text) . ' - click to like" class="like-button-count" id="post-like-button"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . esc_html($db_like_count) . '</span>' . '</button></div>';
    }

    /**
     * Likes displayed on comments
     */
    if (get_comment()) {
        $comment_id = get_comment_ID();
        $comments = lbfw_get_liked_ids($cookie_key . '-comments');
        $comment_count = get_comment_meta($comment_id, $meta_key, true) ?: 0;

        // Checks WP database, if comment meta doesn't exist add a new entry into the database.
        metadata_exists('comment', $comment_id, $meta_key) ?: add_comment_meta($comment_id, $meta_key, 0);

        // Create an aria label string
        $comment_count_text = ($comment_count == 1
            ? $comment_count . ' person liked this'
            : $comment_count . ' people liked this');

        // Check if the comment id is in the cookie. If it is then display without button so visitor can't click again.
        echo in_array((int) $comment_id, $comments, true)
            ? '<div class="comment_vote_off"><span aria-label="' . esc_attr($comment_count_text) . '" class="like-button-comment-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . esc_html($comment_count) . '</span>' . '</span></div>'
            : '<div class="like-button-container-comments" data-comment-like-count="' . esc_attr($comment_count) . '" data-comment-id="' . esc_attr($comment_id) . '"><button aria-label="' . esc_attr($comment_count_text) . ' - click to like this comment" class="like-button-comment-count"><span class="u-icon u-icon--thumbs-o-up"></span>' . ' ' . '<span class="like-button-number">' . esc_html($comment_count) . '</span>' . '</button></div>';
    }
}
