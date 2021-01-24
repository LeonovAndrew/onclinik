function updateForm()
{
    let cityId = $('input[type=radio][name=city]:checked').val(),
        clinicsTypeId = $('#clinicsTypeSelect').val(),
        $wrap = $('#clinics-wrap');

    /**
     * clinics list
     */
    $.ajax({
        'url': ajaxPath,
        'dataType': 'html',
        'data': {
            'cityId' : cityId,
            'typeId' : clinicsTypeId,
            'ajax_filter' : 'Y',
        },
        beforeSend: function(xhr){
            //TODO: preloader
        }
    })
        .done(function(data) {
            $wrap.html(data);
            $('select').styler();
        })
        .fail(function(jqXHR, textStatus) {

        })
}

$(document).ready(function() {
    let $wrap = $('#clinics-wrap');

    $wrap.on('change', function(e) {
        updateForm();
    });
});