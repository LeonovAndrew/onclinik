function updateFilter() {
    let searchQuery = $('#symptomSearch').val(),
        $wrap = $('#directory-wrap'),
        preloaderFilter = new preloader('#symptoms-wrap'),
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
            $('select').styler();
            setFilterUri({
                'search' : searchQuery,
            });
            autocomplete($("#symptomSearch")[0], hintsSymptoms, updateFilter);
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#directory-wrap');

    autocomplete($("#symptomSearch")[0], hintsSymptoms, updateFilter);

    $wrap.on('change', function(e) {
        console.log(e);
        if (e.target.id !== 'symptomSearch' || e.target.value == '') {
            updateFilter();
        }
    });

    /*$wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });*/
});
