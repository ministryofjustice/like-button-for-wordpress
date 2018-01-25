/* plugin jQuery */

(function($) {

  // Variables assigned to data passed on from wp_localize_script() in class-model.php
  var post_id     = LikeButtonData.currentPostID;
      like_count  = LikeButtonData.likeButtonCount;
      wp_ajax     = LikeButtonData.adminAjaxWP;
      like_count  = 836;

  $('.like-click a').attr('href', 'javascript:void(0)');

  $.ajax({
    url: wp_ajax,
    type: 'POST',
    data: ({
      likeCountValue: like_count,
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
      build_post(like_count)
    }
  })

  function build_post(like_count) {
      var inline_like_count = '<h2 style="display: inline;">' + like_count + '<h2>'
      $('.likebutton').replaceWith(inline_like_count);
    }


  // var buttons = document.getElementsByClassName("favorite-button");
  // for(i=0; i < buttons.length; i++) {
  //   buttons.item(i).addEventListener("click", favorite);
  // }


})(jQuery);
