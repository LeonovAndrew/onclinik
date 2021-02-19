function updateFilter() {
    let departmentId = $('input[type=radio][name=department]:checked').val(),
        //clinicId = $('#clinicSelect').val(),
		directionId = $('#directionSelect').val(),
        searchQuery = $('#servicesSearch').val(),
        $wrap = $('#services-wrap'),
        preloaderFilter = new preloader('#services-wrap'),
        data = {
            'departmentId' : departmentId,
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
                'directionId' : $('#directionSelect').val(),
                'search' : searchQuery,
            });

            autocomplete($("#servicesSearch")[0], searchHints, updateFilter);
            readmore('.readmore');
            preloaderFilter.remove();
            if($("#servicesSearch").val()==""){
                $(".clean_search").css("display","none");
            }else{
                $(".clean_search").css("display","block");
            }
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#services-wrap');
    autocomplete($("#servicesSearch")[0], searchHints, updateFilter);

    $wrap.on('change', function(e) {
        if (e.target.id !== 'servicesSearch' || e.target.value == '') {
            updateFilter();
        }
    });


    $wrap.on('submit', function(e) {
        updateFilter();

        return false;
    });
});
