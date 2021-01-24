let map = function(mapId) {
    this.mapId = mapId;
    this.mapInstance = null;
}

map.prototype.init = function(params) {
    this.mapInstance = new ymaps.Map(this.mapId, params, {
        searchControlProvider: 'yandex#search'
    });

    ymaps.templateLayoutFactory.createClass(
        '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
    );
}

map.prototype.disableScrollZoom = function() {
    this.mapInstance.behaviors.disable('scrollZoom');
}

map.prototype.addRoutePanel = function(options, state) {
    this.mapInstance.controls.add('routePanelControl');

    let control = this.mapInstance.controls.get('routePanelControl');

    control.routePanel.options.set(options);
    control.routePanel.state.set(state);
}

map.prototype.routeChange = function(routeOptions, routeState, centerParams) {
    let control = this.mapInstance.controls.get('routePanelControl');

    control.routePanel.options.set(routeOptions);
    control.routePanel.state.set(routeState);

    this.mapInstance.setCenter(centerParams.toCoords, centerParams.zoom);
}

map.prototype.addFeatures = function(features) {
    ymaps.geoQuery(features).setOptions({
        iconLayout: 'default#image',
        iconImageHref: '/upload/medialibrary/609/6095e3ffdf6cfe657ec3a2c1e98c52b7.png',
        iconImageSize: [38, 49],
        iconImageOffset: [-19, -49]
    }).addToMap(this.mapInstance);
}

map.prototype.addPlacemark = function(params) {
    let placemark = new ymaps.Placemark(params.coords, {
            hintContent: params.hintContent,
        }, {
            iconLayout: 'default#image',
            iconImageHref: '/upload/medialibrary/609/6095e3ffdf6cfe657ec3a2c1e98c52b7.png',
            iconImageSize: [38, 49],
            iconImageOffset: [-19, -49]
        });

    this.mapInstance.geoObjects.add(placemark);
}