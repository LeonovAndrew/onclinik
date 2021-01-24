function updateFilter() {
    let searchQuery = $('#diseaseSearch').val(),
        $wrap = $('#directory-wrap'),
        preloaderFilter = new preloader('#directory-wrap'),
        data = {
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
            setFilterUri({
                'search' : searchQuery,
            });
            autocomplete($("#diseaseSearch")[0], hintsDiseases, updateFilter);
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#directory-wrap');

    autocomplete($("#diseaseSearch")[0], hintsDiseases, updateFilter);

    $wrap.on('change', function(e) {
        if (e.target.id !== 'diseaseSearch' || e.target.value == '') {
            updateFilter();
        }
    });

    /*$wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });*/
});
