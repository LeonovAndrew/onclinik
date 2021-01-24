function updateFilter()
{
    let typeId = $('input[type=radio][name=type]:checked').val(),
        directionId = $('#directionSelect').val(),
        clinicId = $('#clinicSelect').val(),
        $wrap = $('#videos-wrap'),
        preloaderFilter = new preloader('#videos-wrap'),
        data = {
            'typeId' : typeId,
            'directionId' : directionId,
            'clinicId' : clinicId,
            'ajax_filter' : 'Y',
        };

    $.ajax({
        'url': ajaxPath,
        'dataType': 'html',
        'data': data,
        beforeSend: function(xhr){
            preloaderFilter.init();
        }
    })
        .done(function(data) {
            $wrap.html(data);
            $('select').styler();
            setFilterUri({
                'typeId' : $('input[type=radio][name=type]:checked').val(),
                'directionId' : $('#directionSelect').val(),
                'clinicId' : $('#clinicSelect').val(),
            });
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#videos-wrap');

    $wrap.on('change', function(e) {
        updateFilter();
    });
});
