$(document).on('mousedown', '.tweet', function () {
    $('#' + $(this).attr('id')).css('z-index', ++z_count);
});

$(document).on('click', '.close', function () {
    $('#' + $(this).parent().parent().attr('id')).remove();
});