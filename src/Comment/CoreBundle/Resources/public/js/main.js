$(function () {
    $('.comment-edit-link').on('click', function (e) {
        e.preventDefault();
        var $target = $(this);
        var $wraper = $target.closest('.comment-edit-wraper');

        $.ajax({
            url: $target.attr('href'),
            type: 'GET',
            success: function (data) {
                $wraper.html(data);
            }
        });
        return false;
    });
});
