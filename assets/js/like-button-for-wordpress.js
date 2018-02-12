/* plugin jQuery */

(function($) {

  var buttons = document.getElementsByClassName("like-button-count");

  for (i = 0; i < buttons.length; i++) {
    buttons.item(i).addEventListener("click", loadData, false);
  }

  function loadData() {

    // Loading required variables. These are loaded in via WP wp_localize_script (see class-model.php)
    var post_id = LikeButtonData.currentPostID;
    var like_count = LikeButtonData.likeButtonCount;
    var wp_ajax = LikeButtonData.adminAjaxWP;

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
    var html = '<span class="like-button-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' + ' ' + '<span class="like-button-number">' + count + '</span>' + '</span>';
    $(".like-button-container").replaceWith(html);
  }

  /* Comments like functionality */

  var comment_like_button = document.getElementsByClassName("like-button-container-comments");

  for (i = 0; i < comment_like_button.length; i++) {
    comment_like_button.item(i).addEventListener("click", loadDataComments, false);
  }

  function loadDataComments() {

    var comment_like_count = this.firstElementChild.childNodes[2].innerHTML;
    var wp_ajax = LikeButtonData.adminAjaxWP;

    // Add clicked css to change button on click
    var parent = this.parentElement.lastElementChild.childNodes[0];
    var like_button_container = this.parentElement.getElementsByClassName("like-button-container-comments")[0];
    like_button_container.classList.add("clicked");

    // This gets and parses the comment ID
    var wp_comment_class = $(this).closest(".comment")[0].id;
    var comment_id_class = (function(wp_comment_class) {
      var match = wp_comment_class.match(/li-comment-(\d+)/);
      return match;
    })(wp_comment_class)

    var commentID = comment_id_class[1];

    var xhr = new XMLHttpRequest();
    xhr.open('POST', wp_ajax, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function() {
      return function(comment_like_count) {
        if (xhr.readyState == 4 && xhr.status == 200) {
          update_likes_comments(comment_like_count);
        }
      }(comment_like_count)
    };

    var comment_like_count = ++comment_like_count;
    var action = 'like_button_ajax_action';
    var post = 'action=' + action + '&commentID=' + commentID + '&likeCommentCountValue=' + comment_like_count + '&cookie=2';
    xhr.send(post);
  }

  function update_likes_comments(count) {
    var comment_like_count = ++comment_like_count;
    var html = '<div class="like-button-comment-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' + ' ' + '<span class="like-button-number">' + count + '</span>' + '</div>';
    $(".clicked").replaceWith(html);
  }

})(jQuery);
