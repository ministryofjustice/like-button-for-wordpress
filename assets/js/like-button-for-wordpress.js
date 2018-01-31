/* plugin jQuery */

(function($) {

  function loadData() {

    // Loading required variables. These are loaded in via WP wp_localize_script (see class-model.php)
    var post_id     = LikeButtonData.currentPostID;
    var like_count  = LikeButtonData.likeButtonCount;
    var wp_ajax     = LikeButtonData.adminAjaxWP;

    // Set up the new AJAX request to the server. I've used Javascript rather then JQuery here as IE8 and lower have problems with AJAX via JQuery.
    var xhr = new XMLHttpRequest();
    xhr.open('POST', wp_ajax, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var like_count = LikeButtonData.likeButtonCount;
        var like_count = ++like_count;
        update_likes(like_count);
      }
    };

    var like_count = ++like_count;
    var action = 'like_button_ajax_action';
    var post = 'action=' + action + '&postID=' + post_id + '&likeCountValue=' + like_count + '&cookie=1';

    xhr.send(post);
  }

  // On click this swaps in the new count on the page. For returning visitors and on page load. I'm using PHP logic for this process. See view-like-button.php
  function update_likes(count) {
    var html = '<span class="like-button-count-unclicked"><span class="u-icon u-icon--thumbs-o-up"></span>' + ' ' + '<span class="like-button-number">' + count + '</span>' + '</span>';
    $(".like-button-container").replaceWith(html);
  }

  var buttons = document.getElementsByClassName("like-button-count");
  for (i = 0; i < buttons.length; i++) {
    buttons.item(i).addEventListener("click", loadData, false);
  }

})(jQuery);
