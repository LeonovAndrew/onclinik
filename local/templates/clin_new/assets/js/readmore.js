function readmore(selector) {
    $(selector).not('.readmore-ent').each(function() {
        let maxHeight,
            curHeight,
            readmoreLayout = '<div class="text-btn">\n' +
                '<i></i>\n' +
                '<span>Показать</span>\n' +
                '<span>Скрыть</span>\n' +
                '</div>';

        maxHeight = (parseInt($(this).css('max-height')));
        $(this).css('max-height','none');
        curHeight =$(this).height();
        $(this).css('max-height','');
        if (curHeight > maxHeight) {
            $(this).addClass('readmore-ent');
            $(readmoreLayout).appendTo($(this));
        } else {
            $(this).addClass('active');
        }
    })
}
