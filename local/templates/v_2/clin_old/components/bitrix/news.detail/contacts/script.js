$(document).ready(function() {
    /**
     * @var mapData - ['mapId', 'params', 'placemarkParams]
     */

    ymaps.ready(function() {
        let contactsMap = new map(mapData.mapId);

        contactsMap.init(mapData.params);
        contactsMap.disableScrollZoom();
        contactsMap.addPlacemark(mapData.placemarkParams);
    });
});