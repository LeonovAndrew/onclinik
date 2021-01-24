function updateFilter() {
    let departmentId = $('input[type=radio][name=department]:checked').val(),
        clinicId = $('#clinicSelect').val(),
        directionId = $('#directionSelect').val(),
        $wrap = $('#stocks-wrap'),
        preloaderFilter = new preloader('#stocks-wrap'),
        data = {
            'departmentId' : departmentId,
            'clinicId' : clinicId,
            'directionId' : directionId,
            'ajax_filter' : 'Y',
        };

    $.ajax({
        'url': ajaxPath,
        'dataType': 'html',
        'data': data,
        beforeSend: function(xhr) {
            preloaderFilter.init();
        }
    })
        .done(function(data) {
            $wrap.html(data);
            $('select').styler();
            setFilterUri({
                'departmentId' : $('input[type=radio][name=department]:checked').val(),
                'clinicId' : $('#clinicSelect').val(),
                'directionId' : $('#directionSelect').val(),
            });
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#stocks-wrap');

    $wrap.on('change', function(e) {
        updateFilter();
    });

    $wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });
});
