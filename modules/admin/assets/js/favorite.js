$(document).ready(function () {
    $('form').on('beforeSubmit', function () {
        var data = $(this).serialize();
        $.ajax({
            url: '/admin/favorite-template/create',
            type: 'POST',
            data: data,
            success: function (res) {
                if (!res.error) {
                    $.pjax.reload({container: '#some_pjax_id', async: false});
                    $('form').trigger('reset');
                }
            },
        });
        return false;
    });
});