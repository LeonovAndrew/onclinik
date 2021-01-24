function updateFilter()
{
    let directionId = $('#directionSelect').val(),
        clinicId = $('#clinicSelect').val(),
        searchQuery = $('#doctorSearch').val(),
        displayed = $('input[type=radio][name=quantity]:checked').val(),
        $wrap = $('#reviews-wrap'),
        preloaderFilter = new preloader('#reviews-wrap'),
        data = {
            'directionId' : directionId,
            'clinicId' : clinicId,
            'search' : searchQuery,
            'displayed' : displayed,
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
            readmore('.readmore');
            setFilterUri({
                'directionId' : $('#directionSelect').val(),
                'clinicId' : $('#clinicSelect').val(),
                'search' : searchQuery,
                'displayed' : $('input[type=radio][name=quantity]:checked').val(),
            });
            autocomplete($("#doctorSearch")[0], hintsDoctorsFilter, updateFilter);
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#reviews-wrap');

    autocomplete($("#doctorSearch")[0], hintsDoctorsFilter, updateFilter);

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