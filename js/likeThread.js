$(document).ready(function () {

    $('.like-checkbox').on('change', function () {
        var checkbox = $(this);
        var threadDiv = checkbox.closest('.thread');
        var threadId = threadDiv.data('thread-id');
        var action = checkbox.is(':checked') ? 'like' : 'unlike';

        $.ajax({
            url: '../php/like_thread.php',
            type: 'POST',
            data: {
                thread_id: threadId,
                action: action
            },
            success: function (response) {
                var data = JSON.parse(response);
                threadDiv.find('.like-count').text(data.like_count);
            }
        });
    });
});
