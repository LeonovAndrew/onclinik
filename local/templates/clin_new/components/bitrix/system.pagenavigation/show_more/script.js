$(document).ready(function() {
    $(document).on('click', '.load_more', function(e) {
        e.preventDefault();

        var targetItemsContainer = $('#ajax-items-list'),      //  Контейнер, в котором хранятся элементы
            targetBtnContainer = $('.more_all'),   //  Контейнер, в котором хранится кнопка загрузки
            targetPaginationContainer = $('.pagination-wrap'),   //  Контейнер, в котором хранится пагинация
            url =  $('.load_more').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                async: false,
                url: url,
                dataType: 'html',
                success: function(data) {
                    //  Удаляем старую навигацию
                    $('.load_more').remove();
                    $('.pagination').remove();

                    var elements = $(data).find('.ajax-item'),//  Ищем элементы
                        loadBtn = $(data).find('.load_more'),//  Ищем кнопку загрузки
                        pagination = $(data).find('.pagination');//  Ищем пагинацию

                    targetItemsContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetBtnContainer.append(loadBtn); //  Добавляем кнопку подгрузки
                    targetPaginationContainer.append(pagination); //  Добавляем пагинацию
                },
            })
        }
    });
});