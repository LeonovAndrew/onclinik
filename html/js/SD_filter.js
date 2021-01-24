function setDirections()
{
    var department = $('input[type=radio][name=department]:checked').val(),
        clinicId = $('#clinicSelect').val(),
        searchQuery = $('#servicesSearch').val(),
        directionsBlock = $('#directions');

    /**
     * directions list
     */
    $.ajax({
        'url': '/ajax/filters/services/directions.php',
        'dataType': 'html',
        'data': {
            'department' : department,
            'clinicId' : clinicId,
            'search' : searchQuery,
        },
        beforeSend: function(xhr){
            //TODO: preloader
        }
    })
        .done(function(data) {
            directionsBlock.html(data);
        })
        .fail(function(jqXHR, textStatus) {

        })
}

function setServices()
{
    var searchQuery = $('#servicesSearch').val(),
        servicesBlock = $('#services');

    /**
     * services list
     */
    $.ajax({
        'url': '/ajax/filters/services/services.php',
        'dataType': 'html',
        'data': {
            'search' : searchQuery,
        },
        beforeSend: function(xhr){
            //console.log('loading');
            //TODO: preloader
        }
    })
        .done(function(data) {
            servicesBlock.html(data);
        })
        .fail(function(jqXHR, textStatus) {

        })
}

$(document).ready(function() {
    setDirections();
    setServices();

    $('.costsection-form').on('change', function(e) {
        $(this).submit();
    });

    $('input[type=radio][name=department]').on('change', function(e) {
        e.stopImmediatePropagation();

        var clinicsWrap = $('.costsection-select-wrap');

        /**
         * clinics list
         */
        $.ajax({
            'url': '/ajax/filters/services/clinics.php',
            'dataType': 'html',
            'data': {
                'department' : $(this).val(),
                'clinicId' : $('#clinicSelect').val(),
            },
            beforeSend: function(xhr){
                //console.log('loading');
                //TODO: preloader
            }
        })
            .done(function(data) {
                clinicsWrap.html(data);
                $('select').styler();
                var res = $(data).find('.direction-item');
                setDirections();
            })
            .fail(function(jqXHR, textStatus) {

            })
    });

    $('.costsection-form').on('submit', function(e) {
        e.preventDefault();

        setDirections();
        setServices();

        return false;
    });
});