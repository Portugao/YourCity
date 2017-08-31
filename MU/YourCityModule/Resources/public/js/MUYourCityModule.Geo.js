'use strict';

var map;
var marker;
var defaultZoomLevel;

/**
 * Initialises geographical display features.
 */
function mUYourCityInitGeographicalDisplay(parameters, isEditMode)
{
    var centerLocation;

    defaultZoomLevel = parameters.zoomLevel;
    centerLocation = new L.LatLng(parameters.latitude, parameters.longitude);

    // create map and center to given coordinates
    map = L.map('mapContainer').setView(centerLocation, parameters.zoomLevel);

    // add tile layer
    L.tileLayer(parameters.tileLayerUrl, {
        attribution: parameters.tileLayerAttribution
    }).addTo(map);

    // add a marker
    marker = new L.marker(centerLocation, {
        draggable: isEditMode
    });
    marker.addTo(map);

    jQuery('#tabMap').on('shown.bs.tab', function () {
        // redraw the map after it's tab has been opened
        map.invalidateSize();
    });
}

/**
 * Callback method for geolocation functionality.
 */
function mUYourCityNewCoordinatesEventHandler() {
    var position;

    position = new L.LatLng(jQuery("[id$='latitude']").val(), jQuery("[id$='longitude']").val());
    marker.setLatLng(position);
    map.setView(position, defaultZoomLevel);
}

/**
 * Callback method for geolocation functionality.
 */
function mUYourCitySetDefaultCoordinates(position) {
    jQuery("[id$='latitude']").val(position.coords.latitude.toFixed(7));
    jQuery("[id$='longitude']").val(position.coords.longitude.toFixed(7));
    mUYourCityNewCoordinatesEventHandler();
}

function mUYourCityHandlePositionError(event) {
    mUYourCitySimpleAlert(jQuery('#mapContainer'), Translator.__('Error during geolocation'), event.message, 'geoLocationAlert', 'danger');
}

/**
 * Initialises geographical editing features.
 */
function mUYourCityInitGeographicalEditing(parameters)
{
    mUYourCityInitGeographicalDisplay(parameters, true);

    // init event handler
    jQuery("[id$='latitude']").change(mUYourCityNewCoordinatesEventHandler);
    jQuery("[id$='longitude']").change(mUYourCityNewCoordinatesEventHandler);

    map.on('click', function(event) {
        var coords = event.latlng;
        jQuery("[id$='latitude']").val(coords.lat.toFixed(7));
        jQuery("[id$='longitude']").val(coords.lng.toFixed(7));
        mUYourCityNewCoordinatesEventHandler();
    });
    marker.on('dragend', function (event) {
        var coords = event.latlng;
        jQuery("[id$='latitude']").val(coords.lat.toFixed(7));
        jQuery("[id$='longitude']").val(coords.lng.toFixed(7));
        mUYourCityNewCoordinatesEventHandler();
    });

    if (true === parameters.useGeoLocation) {
        // derive default coordinates from users position with html5 geolocation feature
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(mUYourCitySetDefaultCoordinates, mUYourCityHandlePositionError, {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 20000
            });
        }
    }
}

jQuery(document).ready(function() {
    var infoElem, parameters;

    infoElem = jQuery('#geographicalInfo');
    if (infoElem.length == 0) {
        return;
    }

    parameters = {
        latitude: infoElem.data('latitude'),
        longitude: infoElem.data('longitude'),
        zoomLevel: infoElem.data('zoom-level'),
        tileLayerUrl: infoElem.data('tile-layer-url'),
        tileLayerAttribution: infoElem.data('tile-layer-attribution'),
        useGeoLocation: false
    };

    if (infoElem.data('context') == 'display') {
        mUYourCityInitGeographicalDisplay(parameters, false);
    } else if (infoElem.data('context') == 'edit') {
        parameters.useGeoLocation = infoElem.data('use-geolocation');
        mUYourCityInitGeographicalEditing(parameters);
    }
});
