function updateFilter() {
    let directionId = $('#directionSelect').val(),
        searchQuery = $('#questionSearch').val(),
        displayed = $('input[type=radio][name=quantity]:checked').val(),
        $wrap = $('#questions-wrap'),
        preloaderFilter = new preloader('#questions-wrap'),
        data = {
            'directionId' : directionId,
            'search' : searchQuery,
            'displayed' : displayed,
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
                'directionId' : $('#directionSelect').val(),
                'search' : searchQuery,
                'displayed' : $('input[type=radio][name=quantity]:checked').val(),
            });
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#questions-wrap');

    $wrap.on('change', function(e) {
        updateFilter();
    });

    $wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });
});
