/* plugin jQuery */

(function($) {

  // Object variables assigned to data passed on from wp_localize_script() in class-model.php
  var post_id = parseInt(LikeButtonData.currentPostID);
      like_count = parseInt(LikeButtonData.likeButtonCount);
      wp_ajax = LikeButtonData.adminAjaxWP;

  const LIKECLICK = document.querySelector(".like-button-container a");

  // Like count comes in and displays on page.
  function set_count(like_count) {
    var html = '<span id="#like-icon" class="u-icon u-icon--thumbs-o-up">' + like_count + '</span>';
    $("#like-icon").replaceWith(html);
  }
  set_count(like_count);

  function addup(like_count) {
    var like_count = like_count + 1;
    return like_count;
  }
  addup(like_count);

  var newlikecount = addup(like_count);

  function like_count_replace(e) {
    e.preventDefault();

    var newlikecount = addup(like_count);
    var html = '<span class="u-icon u-icon--thumbs-o-up">' + newlikecount + '</span>';
    $(".like-button-container a").replaceWith(html);
  }
  set_count();

  LIKECLICK.addEventListener('click', like_count_replace, false);

  //Using native Promises and Deferred AJAX structure
  $.ajax({
    url: wp_ajax,
    type: 'POST',
    data: ({
      likeCountValue: newlikecount,
      postID: post_id,
      action: 'like_button_ajax_action',
    }),

    success: function() {
      console.log('success');
    },

    error: function() {
      console.log('AJAX something went wrong');
    },

    complete: function() {
      console.log('AJAX call completed');
    }
  })

})(jQuery);
