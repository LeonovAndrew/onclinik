/*$(document).ready(function() {
    ymaps.ready(function() {
        let routeMap = new map('testmap'),
            mapParams = {
                center : [55.771996, 37.622262],
                zoom : 15,
            },
            pointCoords = [55.771995, 37.622263],
            routeState = {
                fromEnabled : true,
                toEnabled : false,
                to : pointCoords,
            },
            routeCenterParams = {
                toCoords : pointCoords,
                zoom : 17,
            },
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
            };

        routeMap.init(mapParams);
        routeMap.disableScrollZoom();
        routeMap.addRoutePanel(options, state);
        routeMap.routeChange(options, routeState, routeCenterParams);
    });
});*/