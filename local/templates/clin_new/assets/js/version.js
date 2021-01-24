/**
 * @param color
 * @param size
 * @param width
 */
function setVersion(color, size, width) {
    let url = '/ajax/version.php';

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        data: {
            action: 'update',
            color: color,
            size: size,
            width: width,
        },
    })
        .done(function (response) {
		
			
			
            if (response.success === true) {
                location.reload();
            }
        })
        .fail(function (jqXHR, textStatus) {

        })
}

function toggleVersion() {
    let url = '/ajax/version.php';

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        data: {
            action: 'toggle',
        },
    })
        .done(function (response) {
            if (response.success === true) {
                location.reload();
            }
        })
        .fail(function (jqXHR, textStatus) {

        })
}

$(document).ready(function () {
    $('.colors button').on('click', function (e) {
        e.preventDefault();
        setVersion($(this).data('value'), '', '');
    });

    $('.size button').on('click', function (e) {
        e.preventDefault();

        setVersion('', $(this).data('value'), '');
    });

    $('.width button').on('click', function (e) {
        e.preventDefault();

        setVersion('', '', $(this).data('value'));
    });

    $('.open_visually').on('click', function (e) {
        toggleVersion();
    });

    /**
     * TODO: времянка для сброса ширины. Удалить!
     */
    $('.crutch').on('click', function (e) {
        e.preventDefault();

        setVersion('', '', $(this).data('value'));
    });
});