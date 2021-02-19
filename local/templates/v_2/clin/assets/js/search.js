function liveSearchInit(selector, data, params)
{
    let searchBlock = $(selector),
        resultBlock = $($(selector).siblings('.liveSearchResults')[0]);

    resultBlock.on('click', '.search-res_block', function() {
        resultBlock.html('');
        searchBlock.val($(this).children('.search-res_val').html());
    });

    searchBlock.unbind('keyup');
    searchBlock.keyup(function() {
        let searchField = $(this).val();
        let searchParams = {
            'count': 5
        };
        let resCnt = 0;

        if (params.count > 0) {
            searchParams.count = params.count;
        }

        if (searchField === '') {
            resultBlock.html('');

            return;
        }

        let regex = new RegExp(searchField, "i");
        let output = '<div class="row">';

        $.each(data, function(key, val) {
            if (val.name.search(regex) != -1) {
                output += '<div class="search-res_block">';
                output += '<p class="search-res_val">' + val.name + '</p>';
                output += '</div>';

                if (++resCnt >= searchParams.count) {
                    return false;
                }
            }
        });
        output += '</div>';

        resultBlock.html(output);
    });
}

$(document).ready(function() {
    /**plagin chosen*/
    /*var config = {
        '.chosen-select'           : {width: '100%'},
    }*/
    /*for (var selector in config) {
        $(selector).chosen(config[selector]);
    }*/

    /**
     * Тестовый поиск на странице /testsearch/
     */
    let testData = [
        {
            'name' : 'Врач 1',
        },
        {
            'name' : 'Врач 2',
        },
        {
            'name' : 'Врач 3',
        },
        {
            'name' : 'Админ 1',
        },
        {
            'name' : 'Администратор',
        },
        {
            'name' : 'Роза',
        },
        {
            'name' : 'Урынгалиевна',
        }
    ];

    liveSearchInit(
        '#testSearch',
        testData,
        {
            'count' : 5
        }
    )
});