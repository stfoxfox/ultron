$(function(){
   $(document).on("click", ".js-receive-flag", function(){
       $this = $(this);
       $.ajax({
            url: $this.data('url'),
            type: 'POST',
            data: {
                'receive_flag': $this.is(':checked') ? 1 : 0
            },
            beforeSend: function (xhr, settings) {
                $this.find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $this.find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.comments('updateErrors', $this, xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {

            }
        });
   })
});