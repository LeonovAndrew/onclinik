function setPrograms()
{
    let clientsType = $('input[type=radio][name=clientsType]:checked').val(),
        programTypeId = $('#programTypeSelect').val(),
        programsBlock = $('#programs');

    /**
     * programs list
     */
    $.ajax({
        'url': '/ajax/filters/programs/programs.php',
        'dataType': 'html',
        'data': {
            'clientsType' : clientsType,
            'programType' : programTypeId,
        },
        beforeSend: function(xhr){
            //TODO: preloader
        }
    })
        .done(function(data) {
            programsBlock.html(data);
        })
        .fail(function(jqXHR, textStatus) {

        })
}

$(document).ready(function() {
    $('.costsection-form').on('change', function(e) {
        $(this).submit();
    });

    $('input[type=radio][name=clientsType]').on('change', function(e) {
        e.stopImmediatePropagation();

        let programsTypesWrap = $('.clinics-filter-select-wrap');

        /**
         * programs types list
         */
        $.ajax({
            'url': '/ajax/filters/programs/programsTypes.php',
            'dataType': 'html',
            'data': {
                'clientsType' : $(this).val(),
                'programType' : $('#programTypeSelect').val(),
            },
            beforeSend: function(xhr){
                //console.log('loading');
                //TODO: preloader
            }
        })
            .done(function(data) {
                programsTypesWrap.html(data);
                $('select').styler();
                setPrograms();
            })
            .fail(function(jqXHR, textStatus) {

            })
    });

    $('.costsection-form').on('submit', function(e) {
        e.preventDefault();

        setPrograms();

        return false;
    });
});