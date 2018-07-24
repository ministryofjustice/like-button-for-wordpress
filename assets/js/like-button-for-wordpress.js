/* plugin jQuery */

(function($) {
  // "use strict";

  $("#post-like-button").click(function(e) {
    loadData(e);
  });

  function loadData(e) {

    var postID = '';
    var likeCount = '';
    
    var postID = LikeButtonData.currentPostID;
    var likeCount = LikeButtonData.likeButtonCount;
    var wpAjax = LikeButtonData.adminAjaxWP;
    var nonce = LikeButtonData.likeNonce;

    e.preventDefault();

    var likeCount = ++likeCount;
    updateLikes(likeCount);

    $.ajax({
      url: wpAjax,
      type: 'POST',
      contentType: 'application/x-www-form-urlencoded',
      data:
        ({
          likeCountValue: likeCount,
          postID: postID,
          cookie: '1',
          action: 'like_button_ajax_action',
          security: nonce,
        }),
      complete: updateLikes
    });

    function updateLikes(count) {
      var html = '<span class="like-button-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' + ' ' + '<span class="like-button-number">' + count + '</span>' + '</span>';
      $(".like-button-container").replaceWith(html);
    }
  }

  // IE7 compatibility conditional - if no addEventListener
  $(".like-button-container-comments").each(function() {
    if (this.addEventListener) {
      this.addEventListener("click", loadDataComments, false);
    } else {
      this.attachEvent("onclick", loadDataComments, false);
    }
  });

  function loadDataComments(e) {

    // IE7 compatibility conditional - if no addEventListener, then it is IE7 or 8 and can use e.srcElement.
    if (this.addEventListener) {
      var addClicked = $(this).addClass("clicked");
      var likeCount = $(this).data("comment-like-count");
      var commentID = $(this).data("comment-id");
      var nonce = LikeButtonData.likeNonce;
    } else {
      var container = $(e.srcElement).parent();
      var addClicked = container.addClass("clicked");
      var likeCount = container.data("comment-like-count");
      var commentID = container.data("comment-id");
      var nonce = LikeButtonData.likeNonce;
    }

    var wpAjax = LikeButtonData.adminAjaxWP;
    var likeCount = ++likeCount;

    updateLikes(likeCount);

    $.ajax({
      url: wpAjax,
      type: 'POST',
      contentType: 'application/x-www-form-urlencoded',
      data:
        ({
          likeCommentCountValue: likeCount,
          commentID: commentID,
          cookie: '2',
          action: 'like_button_ajax_action',
          security: nonce,
        }),
      complete: updateLikes
    });
  }

  function updateLikes(count) {
    var html = '<div class="like-button-comment-count-clicked"><span class="u-icon u-icon--thumbs-o-up"></span>' + ' ' + '<span class="like-button-number">' + count + '</span>' + '</div>';
    $(".clicked").replaceWith(html);
  }

})(jQuery);
