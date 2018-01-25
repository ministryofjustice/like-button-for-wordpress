<?php
/**
 * Displays the view for the Like Button For Wordpress .
 *
 * This is a partial template that is included by the Like Button For Wordpress
 * view class that is used to display the html for the like button.
 *
 * @package LBFW
 */

// block of code to use on the Clarity theme to update the like count from the old like system.
// update_post_meta(get_the_ID(), 'dw_inc_likes', 20000); //16
// $metavalues = get_post_meta(get_the_ID(), 'dw_inc_likes');
// foreach ($metavalues as $metavalue) {
//   echo $metavalue;
// }
$post_id = get_the_ID();
//
// if (isset($_GET['type'], $_GET['id'])) {
//     $type = $_GET['type'];
//     $id   = (int)$_GET['id'];
//
//     switch ($type) {
//     case 'post':
//       echo $id.$type.'hello';
//     break;
//   }
// }
//?type=post&id=3
//get_post_meta( 96848, 'lbfw_likes_count', 30001);

//$metavalues = get_post_meta(get_the_ID(), 'lbfw_likes_count');
// function like_button_for_wordpress_api_view() {
//           $get_post_meta_count = get_post_meta( $post_id, 'lbfw_likes_count', 30001);
//           return $get_post_meta_count;
//   }
if(!metadata_exists('post',$post_id, 'lbfw_likes_count')) {
  add_post_meta( $post_id, 'lbfw_likes_count', 0);
}
?>
<div class="like-click">
<h2 style="display: inline;"><a href="#"><span class="u-icon u-icon--thumbs-o-up"></h2>
<div class="likebutton">... Loading Like count ...</div></span></a>
</div>
