/* plugin jQuery */

(function($) {

  // Object variables assigned to data passed on from wp_localize_script() in class-model.php
  var post_id = parseInt(LikeButtonData.currentPostID);
      like_count = parseInt(LikeButtonData.likeButtonCount);
      wp_ajax = LikeButtonData.adminAjaxWP;

  const LIKECLICK = document.querySelector(".like-button-container a");

  if(isNaN(like_count)) {
    var like_count = 0;
  }

  // Like count comes in and displays on page.
  function set_count(like_count) {
    var html = '<span id="#like-icon" class="u-icon u-icon--thumbs-o-up">' + like_count + '</span>';
    $("#like-icon").replaceWith(html);
  }
  set_count(like_count);

  function block(e) {
    e.preventDefault();
  }

  function like_count_replace(a) {
    var a;
    var a = a + 1;
    var html = '<span class="u-icon u-icon--thumbs-o-up">' + a + '</span>';
    $(".like-button-container a").replaceWith(html);
    var b = 1;
    loadData(a, b);
  }

  LIKECLICK.addEventListener('click', function(e) {block(e); }, false);
  LIKECLICK.addEventListener('click', function() {like_count_replace(like_count); }, false);

function loadData(a,b) {
  //Using native Promises and Deferred AJAX structure
  $.ajax({
    url: wp_ajax,
    type: 'POST',
    data: ({
      likeCountValue: a,
      postID: post_id,
      cookie: b,
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
}
})(jQuery);
