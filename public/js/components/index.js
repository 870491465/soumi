
$(document.body).on('click', '.openModal', function(e) {
    e.preventDefault = false;
    var $modal = $('.ui.modal');
    $modal.modal('show');
});


$('button.submit').on('click', function() {
    $('form.ajax').submit();
})

/*
 * --------------------
 * Create a simple way to show remote dynamic modals from the frontend
 * --------------------
 *
 * E.g :
 * <a href='/route/to/modal' class='loadModal'>
 *  Click For Modal
 * </a>
 *
 */
$('.loadModal').on('click', function (e) {
    var loadUrl = $(this).data('href'),
        cacheResult = $(this).data('cache') === 'on',
        $button = $(this);

    $('.ui.modal').remove();
    $('html').addClass('working');

    $.ajax({
        url: loadUrl,
        data: {},
        localCache: cacheResult,
        dataType: 'html',
        success: function (data) {
            $('body').append(data);

            var $modal = $('.ui.modal');
            $modal.modal('show');

            $('html').removeClass('working');

        }
    }).done().fail(function (data) {
        $('html').removeClass('working');
        showMessage('Whoops!, something has gone wrong.<br><br>' + data.status + ' ' + data.statusText);
    });
    e.preventDefault();
});



/*
 * --------------------
 * Ajaxify those forms
 * --------------------
 *
 * All forms with the 'ajax' class will automatically handle showing errors etc.
 *
 */
$('form.ajax').ajaxForm({
    delegation: true,
    beforeSubmit: function (formData, jqForm, options) {

        $(jqForm[0])
            .find('.error.help-block')
            .remove();
        $(jqForm[0]).find('.error')
            .removeClass('error');

        var $submitButton = $(jqForm[0]).find('button[type=submit]');
        toggleSubmitDisabled($submitButton);


    },
    uploadProgress: function (event, position, total, percentComplete) {
        $('.uploadProgress').show().html('Uploading Images - ' + percentComplete + '% Complete...    ');
    },
    error: function (data, statusText, xhr, $form) {

        // Form validation error.
        if (422 == data.status) {
            processFormErrors($form, $.parseJSON(data.responseText));
            return;
        }

        showMessage('Whoops!, it looks like the server returned an error.','humane-flatty-error');

        var $submitButton = $form.find('button[type=submit]');
        toggleSubmitDisabled($submitButton);

        $('.uploadProgress').hide();
    },
    success: function (data, statusText, xhr, $form) {

        switch (data.status) {
            case 'success':
                var collapse = $form.data('opencollapse');
                if (collapse !='' && collapse !=null && typeof(collapse) !='underfine') {
                    $('#'+collapse).collapse('show');
                }

                if ($form.hasClass('reset')) {
                    $form.resetForm();
                }

                if ($form.hasClass('closeModalAfter')) {
                    $('.modal, .modal-backdrop').fadeOut().remove();
                }

                var $submitButton = $form.find('button[type=submit]');
                toggleSubmitDisabled($submitButton);

                if (typeof data.message !== 'undefined') {
                    showMessage(data.message,'humane-flatty-success');
                }

                if (typeof data.runThis !== 'undefined') {
                    eval(data.runThis);
                }

                if (typeof data.redirectUrl !== 'undefined') {
                    window.location.href = data.redirectUrl;
                }

                if (typeof data.modalView !== 'undfined') {
                    $('.modal').modal('hide');
                    $('.modal').removeClass('modal');
                    $('.modal').remove();
                    $('body').append(data.modalView);
                    var $modal = $('#'+data.modal);

                    $modal.modal('show');
                }

                break;
            case 'info':
                var $submitButton = $form.find('input[type=submit]');
                toggleSubmitDisabled($submitButton);

                if (typeof data.message !== 'undefined') {
                    showMessage(data.message,'humane-flatty-info');
                }
                break;
            case 'error':
                processFormErrors($form, data.messages);
                break;
            case 'sms' :
                var $submitButton = $form.find('input[type=submit]');
                toggleSmsSubmitDisabled($submitButton);
                if (typeof data.message !== 'undefined') {
                    showMessage(data.message,'humane-flatty-success');
                }
                openInputCode();
                break;
            default:
                break;
        }

        $('.uploadProgress').hide();
    },
    dataType: 'json'
});

/**
 *
 * @param elm $submitButton
 * @returns void
 */
function toggleSubmitDisabled($submitButton) {

    if ($submitButton.hasClass('disabled')) {
        $submitButton.attr('disabled', false)
            .removeClass('disabled loading')
            .val($submitButton.data('original-text'));
        return;
    }

    $submitButton.data('original-text', $submitButton.val())
        .attr('disabled', true)
        .addClass('disabled loading');

}


var wait=60;
function time(o) {
    if (wait == 0) {
        o.removeClass('disabled')
        o.val(o.data('original-text'));
        wait = 60;
    } else {
        o.val(wait);
        wait--;
        setTimeout(function() {
                time(o)
            },
            1000)
    }
}


function processFormErrors($form, errors)
{
    $.each(errors, function (index, error)
    {
        var $input = $(':input[name=' + index + ']', $form);

        if ($input.prop('type') === 'file') {
            $('#input-' + $input.prop('name')).append('<div class="ui basic red pointing prompt label transition visible">' + error + '</div>')
                .parent()
                .addClass('error');
        } else {
            $input.parent().after('<div class="ui basic red pointing prompt label transition visible">' + error + '</div>').parent().parent().addClass('error');
        }
    });

    var $submitButton = $form.find('button[type=submit]');
    toggleSubmitDisabled($submitButton);
}


/**
 * Shows users a message.
 * Currently uses humane.js
 *
 * @param string message
 * @returns void
 */
function showMessage(message,$class) {
    alert(message);
}