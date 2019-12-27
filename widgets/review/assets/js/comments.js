(function ($) {
    // Comments plugin
    $.comments = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.comments');
            return false;
        }
    };

    // Default settings
    var defaults = {
        listSelector: '[data-comment="list"]',
        parentSelector: '[data-comment="parent"]',
        appendSelector: '[data-comment="append"]',
        formSelector: '[data-comment="form"]',
        appealFormSelector: '[data-comment="appeal-form"]',
        contentSelector: '[data-comment="content"]',
        toolsSelector: '[data-comment="tools"]',
        formGroupSelector: '[data-comment="form-group"]',
        errorSummarySelector: '[data-comment="form-summary"]',
        errorSummaryToggleClass: 'hidden',
        errorClass: 'has-error',
        offset: 0
    };

    function form_reload(form) {
        $.ajax({
            url: $('.box_reviews').data('url'),
            type: 'GET',
            beforeSend: function (xhr, settings) {
                $(this).find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $(this).find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.comments('updateErrors', $(this), xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $('.box_reviews').html(response);
            }
        });
    }

    // Edit the comment
    $(document).on('click', '[data-comment="update"]', function (evt) {
        evt.preventDefault();
        $('.content-reply').html('');
        var data = $.data(document, 'comments'),
            $this = $(this);
        $.ajax({
            url: $this.data('comment-url'),
            type: 'GET',
            beforeSend: function (xhr, settings) {
                $(this).find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $(this).find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.comments('updateErrors', $(this), xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $this.closest('[data-comment="parent"][data-comment-id="' + $this.data('comment-id') + '"]').find('.content-reply').first().html(response);
            }
        });
    });

    // Reply to comment
    $(document).on('click', '[data-comment="reply"]', function (evt) {
        evt.preventDefault();
        $('.content-reply').html('');
        var data = $.data(document, 'comments'),
            $this = $(this);
        $.ajax({
            url: $this.data('comment-url'),
            type: 'GET',
            beforeSend: function (xhr, settings) {
                $(this).find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $(this).find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.comments('updateErrors', $(this), xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $this.parents('[data-comment="parent"][data-comment-id="' + $this.data('comment-id') + '"]').find('.content-reply').first().html(response);
            }
        });
    });

    // Appeal to comment
    $(document).on('click', '[data-comment="appeal"]', function (evt) {
        evt.preventDefault();
        $('.content-reply').html('');

        if (!confirm("Вы действительно хотите отправить жалобу администратору сайта от своего имени на содержание данного сообщения?")) {
          return;
        }

        var data = $.data(document, 'comments');
        var $this = $(this);
        $.ajax({
            url: $this.data('comment-url'),
            type: 'GET',
            beforeSend: function (xhr, settings) {
                $(this).find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $(this).find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.comments('updateErrors', $(this), xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $this.parents('[data-comment="parent"][data-comment-id="' + $this.data('comment-id') + '"]').find('.content-reply').first().html(response);
            }
        });
    });

    // Delete comment
    $(document).on('click', '[data-comment="delete"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'comments'),
            $this = $(this);

        if (confirm($this.data('comment-confirm'))) {
            $.ajax({
                url: $this.data('comment-url'),
                type: 'DELETE',
                error: function (xhr, status, error) {
                    alert('error');
                },
                success: function (result, status, xhr) {
                    $this.parents('[data-comment="parent"][data-comment-id="' + $this.data('comment-id') + '"]').find(data.contentSelector).first().text(result);
                    $this.closest('.well').find(data.toolsSelector).remove();
                }
            });
        }
    });

    // Scroll to parent comment
    $(document).on('click', '[data-comment="ancor"]', function (evt) {
        evt.preventDefault();
        $.comments('scrollTo', $(this).data('comment-parent'));
    });

    // AJAX updating form submit
    $(document).on('submit', '[data-comment-action="update"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'comments'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
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
                $(data.listSelector).html(response);
                $.comments('removeForm');
            }
        });
    });

    // AJAX reply form submit
    $(document).on('submit', '[data-comment-action="reply"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'comments'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
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
                $(data.listSelector).html(response);
                $.comments('removeForm');
            }
        });
    });

    // AJAX create form submit
    $(document).on('submit', '[data-comment-action="create"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'comments'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
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
                // $(data.listSelector).html(response);
                form_reload($this);
                // $.comments('clearErrors', $this);
                // $this.trigger('reset');
            }
        });
    });

    $(document).on('submit', '[data-comment-action="appeal"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'comments'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            beforeSend: function (xhr, settings) {
                $this.find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $this.find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    // $.comments('updateErrors', $this, xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $this.remove();
                alert('Ваше сообщение отправлено!');
            }
        });
    });



    // Methods
    var methods = {
        init: function (options) {
            if ($.data(document, 'comments') !== undefined) {
                return;
            }

            // Set plugin data
            $.data(document, 'comments', $.extend({}, defaults, options || {}));

            return this;
        },
        destroy: function () {
            $(document).unbind('.comments');
            $(document).removeData('comments');
        },
        data: function () {
            return $.data(document, 'comments');
        },
        createForm: function () {
            var data = $.data(document, 'comments'),
                $form = $(data.formSelector),
                $clone = $form.clone();

            methods.removeForm();

            $clone.removeAttr('id');
            $clone.attr('data-comment', 'js-form');

            data.clone = $clone;
        },
        removeForm: function () {
            var data = $.data(document, 'comments');

            if (data.clone !== undefined) {
                $('[data-comment="js-form"]').remove();
                data.clone = undefined;
            }
        },
        scrollTo: function (id) {
            var data = $.data(document, 'comments'),
                topScroll = $('[data-comment="parent"][data-comment-id="' + id + '"]').offset().top;
            $('body, html').animate({
                scrollTop: topScroll - data.offset
            }, 500);
        },
        updateErrors: function ($form, response) {
            var data = $.data(document, 'comments'),
                message = '';

            $.each(response, function (id, msg) {
                $('#' + id).closest(data.formGroupSelector).addClass(data.errorClass);
                message += msg;
            });

            $form.find(data.errorSummarySelector).toggleClass(data.errorSummaryToggleClass).text(message);
        },
        clearErrors: function ($form) {
            var data = $.data(document, 'comments');

            $form.find('.' + data.errorClass).removeClass(data.errorClass);
            $form.find(data.errorSummarySelector).toggleClass(data.errorSummaryToggleClass).text('');
        }
    };
})(window.jQuery);