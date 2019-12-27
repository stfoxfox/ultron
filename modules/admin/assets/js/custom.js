$(document).ready(function () {

    $('#delete-selected').on('click', function (e) {
        e.preventDefault();

        if (!confirm('Вы уверены что хотите бзвозвратно удалить эти элементы?')) {
            return;
        }

        var ids = [];
        $('[data-delete-selected-id]:checked').each(function () {
            ids.push($(this).attr('data-delete-selected-id'));
        });

        $.post($(this).attr('href'), {
            'ids': JSON.stringify(ids)
        }, function (resp) {
            window.location.reload();
        });
    });

    $('[data-delete-selected-id]').on('change', function () {
        var len = $('[data-delete-selected-id]:checked').length;
        if (len > 0) {
            $('#delete-selected').removeClass('disabled');
        } else {
            $('#delete-selected').addClass('disabled');
        }
    });

    $('html').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    $(document).on('click', '[data-payout-max-sum]', function (e) {
        e.preventDefault();
        $('#payout-sum').val($(this).attr('data-payout-max-sum'));
    });

    $(document).on('click', '[data-payout-preferred-system]', function (e) {
        e.preventDefault();
        $('#payout-payment_type').val($(this).attr('data-payout-preferred-system'));
    });

    $(document).on('change', '#template-category_ids', function (e) {
        e.preventDefault();

        $.get($('#template-tag_ids').data('url'), {
            categories: $(this).val()
        }, function (r) {
            $('#template-tag_ids').html(JSON.parse(r));
        });
    });

    // инициализация плагина jquery.maskedinput.js
    if (typeof $.mask !== "undefined") {
        $.mask.definitions['~'] = '[+-]';
        $('.tel').mask('+7(999) 999-9999');
        $('#webmoney_wmr').mask('R999999999999');
        $('#webmoney_wmz').mask('Z999999999999');
        $('#yandex_money').mask('9999999999999?9999');
    }

    /*$('.deleteBtn').click(function () {
        event.preventDefault();
        event.stopPropagation();
        var modal = $('#deleteModal');
        var id = $(this).attr('data-id');
        console.log(id);
        modal.find('.id-field').val(id);
        modal.modal();
	return false;
    });*/


    $(document).on('click', '.deleteBtn', function (event) {
        event.preventDefault();
        event.stopPropagation();
        var modal = $('#deleteModal');
        var id = $(this).attr('data-id');
        console.log(id);
        modal.find('.id-field').val(id);
        modal.modal();
	return false;
    });

});