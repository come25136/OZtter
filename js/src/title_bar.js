$(document).on('click', '.close', function () {
    console.log($(this).parent().parent().attr('id'));

    $('#' + $(this).parent().parent().attr('id')).remove();
});