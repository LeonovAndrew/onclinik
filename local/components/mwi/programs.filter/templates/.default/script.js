function updateFilter()
{
    let patientsTypeId = $('input[type=radio][name=patientsType]:checked').val(),
        programsTypeId = $('#programTypeSelect').val(),
        $wrap = $('#programs-wrap'),
        preloaderFilter = new preloader('#programs-wrap'),
        data = {
            'patientsTypeId' : patientsTypeId,
            'programsTypeId' : programsTypeId,
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
                'patientsTypeId' : $('input[type=radio][name=patientsType]:checked').val(),
                'programsTypeId' : $('#programTypeSelect').val(),
            });
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#programs-wrap');

    $wrap.on('change', function(e) {
        updateFilter();
    });
});