$(document).on('click', '.close', function () {
    $('#' + $(this).parent().parent().attr('id')).remove();
});