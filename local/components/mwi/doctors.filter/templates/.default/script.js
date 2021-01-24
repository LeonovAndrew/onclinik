function updateFilter() {
    let departmentId = $('input[type=radio][name=department]:checked').val(),
        clinicId = $('#clinicSelect').val(),
        directionId = $('#directionSelect').val(),
        searchQuery = $('#doctorSearch').val(),
        $wrap = $('#doctors-wrap'),
        preloaderFilter = new preloader('#doctors-wrap'),
        data = {
            'departmentId' : departmentId,
            'clinicId' : clinicId,
            'directionId' : directionId,
            'search' : searchQuery,
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
                'search' : searchQuery,
            });

            autocomplete($("#doctorSearch")[0], hintsDoctors, updateFilter);
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#doctors-wrap');
    autocomplete($("#doctorSearch")[0], hintsDoctors, updateFilter);

    $wrap.on('change', function(e) {
        if (e.target.id !== 'doctorSearch' || e.target.value == '') {
            updateFilter();
        }
    });

    /*$wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });*/
});
