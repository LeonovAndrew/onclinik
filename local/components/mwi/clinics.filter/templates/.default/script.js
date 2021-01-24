function updateFilter()
{
    let cityId = $('input[type=radio][name=city]:checked').val(),
        clinicsTypeId = $('#clinicsTypeSelect').val(),
        $wrap = $('#clinics-wrap'),
        preloaderFilter = new preloader('#clinics-wrap'),
        data = {
            'cityId' : cityId,
            'typeId' : clinicsTypeId,
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
                'cityId' : $('input[type=radio][name=city]:checked').val(),
                'typeId' : $('#clinicsTypeSelect').val(),
            });
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
}

$(document).ready(function() {
    let $wrap = $('#clinics-wrap');

    $wrap.on('change', function(e) {
        updateFilter();
    });
});