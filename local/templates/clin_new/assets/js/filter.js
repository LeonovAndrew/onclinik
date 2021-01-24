function setFilterUri(params) {
    let uriParams = {};

    $.each(params, function(key, value) {
        if (value !== '' && key !== 'ajax_filter') {
            uriParams[key] = value;
        }
    });
    if (!$.isEmptyObject(uriParams)) {
        history.pushState(null, '', location.pathname + '?' + $.param(uriParams));
    }
}