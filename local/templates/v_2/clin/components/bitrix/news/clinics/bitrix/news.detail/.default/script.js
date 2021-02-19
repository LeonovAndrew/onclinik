let routeMap,
    options = {
        types : {
            auto : true,
            pedestrian : true,
            masstransit : true,
        }
    },
    state = {
        fromEnabled : true,
        toEnabled : false,
    },
    routeState = {
        fromEnabled : true,
        toEnabled : false,
        to : clinicCoords,
    },
    routeCenterParams = {
        toCoords : clinicCoords,
        zoom : 17,
    };

$(document).ready(function() {

	$.getScript( "https://api-maps.yandex.ru/2.1/?apikey=870293a8-8ba5-4fd8-9948-dbc7ed29b9a7&lang=ru_RU" )
		.done(function( script, textStatus ) {
			ymaps.ready(function() {
				let mapParams = {
						center : clinicCoords,
						zoom : 15,
					},
					placemarkParams = {
						coords : clinicCoords,
						hintContent : clinicName,
					};
				routeMap = new map('map');

				routeMap.init(mapParams);
				routeMap.addPlacemark(placemarkParams);
				routeMap.disableScrollZoom();

				if (paveRoute) {
					routeMap.addRoutePanel(options, state);
					routeMap.routeChange(options, routeState, routeCenterParams);
				}
			});
		});
});

$('#pave-route').on('click', function(e) {
    e.preventDefault();

    routeMap.addRoutePanel(options, state);
    routeMap.routeChange(options, routeState, routeCenterParams);
});

$('.tour').on('click', function(e) {
    e.preventDefault();

    let clinicId = $(this).data('id'),
        $wrap = $('.clinic-tour-img-wrap'),
        preloaderFilter = new preloader('.clinic-tour-img-wrap'),
        data = {
            'clinicId' : clinicId,
        };

    $.ajax({
        'url': '/ajax/3d_tour.php',
        'type': 'post',
        'dataType': 'json',
        'data': data,
        beforeSend: function(xhr){
            preloaderFilter.init();
        }
    })
        .done(function(response) {
            $wrap.html(response.data.tour);
            preloaderFilter.remove();
        })
        .fail(function(jqXHR, textStatus) {
            preloaderFilter.remove();
        })
});

