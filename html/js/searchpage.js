function clearSelected(id) {
    let elements = document.getElementById(id).options;

    for (let i = 0; i < elements.length; i++) {
        elements[i].selected = false;
    }
}

function setSearch()
{
    var searchQuery = $('#servicesSearch').val(),
        directionsBlock = $('.search-list1');

    /**
     * directions list
     */
    $.ajax({
        'url': '/ajax/filters/services/search.php',
        'dataType': 'html',
        'data': {
            'searchQuery' : searchQuery,
        },
        beforeSend: function(xhr){
            //TODO: preloader
        }
    })
        .done(function(data) {
            directionsBlock.html(data);
            $('.search-count').html(directionsBlock.find('.search-item').length);
        })
        .fail(function(jqXHR, textStatus) {

        })
}


$(document).ready(function() {
    setSearch();

    $('.search-form').on('change', function(e) {
        $(this).submit();
    });

    $('.search-form').on('submit', function(e) {
        e.preventDefault();

        setSearch();

        return false;
    });
});