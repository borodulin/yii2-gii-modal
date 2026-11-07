/**
 * Modal CRUD for Yii2: loads pages into a Bootstrap 3/4/5 modal and submits their forms via AJAX.
 * @link https://github.com/borodulin/yii2-gii-modal
 */
(function ($) {
    'use strict';

    // the script may be injected again together with an AJAX response
    if (window.conquerGiiModal) {
        return;
    }
    window.conquerGiiModal = true;

    function showModal(modal) {
        var bs = window.bootstrap;
        if (typeof modal.modal === 'function') {
            modal.modal('show');
        } else if (bs && bs.Modal) {
            // Bootstrap 5 without the jQuery interface
            (bs.Modal.getInstance(modal[0]) || new bs.Modal(modal[0])).show();
        }
    }

    function setHeader(modal, text) {
        var title = modal.find('.modal-title').first();
        if (title.length === 0) {
            title = $('<h4 class="modal-title"></h4>').prependTo(modal.find('.modal-header').first());
        }
        title.text(text);
    }

    function load(container, settings) {
        $.ajax($.extend({
            success: function (response) {
                container.html(response);
            },
            error: function (jqXHR) {
                // a successful save answers with X-Redirect, which yii.js follows
                if (jqXHR.getResponseHeader('X-Redirect')) {
                    return;
                }
                container.html($('<div class="error-summary"></div>').html(jqXHR.responseText));
            }
        }, settings));
    }

    $(document).on('click', '.show-modal', function (event) {
        var link = $(this),
            modal = $(link.attr('data-target')),
            url = link.attr('data-url') || link.attr('href');
        if (!url || modal.length === 0) {
            return;
        }
        event.preventDefault();
        setHeader(modal, link.attr('data-header') || '');
        var body = modal.find('.modal-body').first().empty();
        showModal(modal);
        load(body, {url: url});
    });

    $(document).on('submit', 'form[data-ajax]', function (event) {
        var form = $(this),
            body = form.closest('.modal-body');
        // outside a modal (a page opened directly) the form is submitted normally
        if (body.length === 0) {
            return;
        }
        event.preventDefault();
        var data = new FormData(this);
        body.empty();
        load(body, {
            url: form.attr('action'),
            type: form.attr('method') || 'post',
            processData: false,
            contentType: false,
            data: data
        });
    });

    $(document).on('click', 'a[data-ajax]', function (event) {
        var link = $(this),
            body = link.closest('.modal-body');
        if (body.length === 0) {
            return;
        }
        event.preventDefault();
        body.empty();
        load(body, {url: link.attr('href')});
    });
})(jQuery);
