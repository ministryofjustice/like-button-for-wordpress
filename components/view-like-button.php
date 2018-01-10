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

if(isset($_GET['type'], $_GET['id'])) {

  $type = $_GET['type'];
  $id   = (int)$_GET['id'];

  switch($type) {
    case 'post':
      echo $id.$type.'hello';
    break;
  }

}
//add_post_meta( 96848, 'lbfw_likes_count', 30000);

$metavalues = get_post_meta(get_the_ID(), 'lbfw_likes_count');
foreach ($metavalues as $metavalue) {
  echo $metavalue;
}
?>

<span class="u-icon u-icon--thumbs-o-up"></span>
<a class="like-link" href="?type=post&id=3"><?php echo $metavalue; ?></a>
