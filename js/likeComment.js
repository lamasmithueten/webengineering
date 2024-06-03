$(document).ready(function () {
    // Retrieve user ID from the embedded data attribute
    var userId = $('#user-data').data('user-id');

    $('.like-checkbox').on('change', function () {
        var checkbox = $(this);
        var commentDiv = checkbox.closest('.comment');
        var commentId = commentDiv.data('comment-id');
        var action = checkbox.is(':checked') ? 'like' : 'unlike';

        $.ajax({
            url: '../php/like_comment.php',
            type: 'POST',
            data: {
                user_id: userId,
                comment_id: commentId,
                action: action
            },
            success: function (response) {
                var data = JSON.parse(response);
                commentDiv.find('.like-count').text(data.like_count);
            }
        });
    });
});