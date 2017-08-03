'use strict';

var mapstraction;
var marker;
var defaultZoomLevel;

/**
 * Initialises geographical display features.
 */
function mUYourCityInitGeographicalDisplay(latitude, longitude, mapType, zoomLevel)
{
    defaultZoomLevel = zoomLevel;

    mapstraction = new mxn.Mapstraction('mapContainer', 'googlev3');
    mapstraction.addControls({
        pan: true,
        zoom: 'small',
        map_type: true
    });

    var location = new mxn.LatLonPoint(latitude, longitude);

    if (mapType == 'roadmap') {
        mapstraction.setMapType(mxn.Mapstraction.ROAD);
    } else if (mapType == 'satellite') {
        mapstraction.setMapType(mxn.Mapstraction.SATELLITE);
    } else if (mapType == 'hybrid') {
        mapstraction.setMapType(mxn.Mapstraction.HYBRID);
    } else if (mapType == 'physical') {
        mapstraction.setMapType(mxn.Mapstraction.PHYSICAL);
    } else {
        mapstraction.setMapType(mxn.Mapstraction.ROAD);
    }

    mapstraction.setCenterAndZoom(location, defaultZoomLevel);
    mapstraction.mousePosition('position');

    // add a marker
    marker = new mxn.Marker(location);
    mapstraction.addMarker(marker, true);

    jQuery('#collapseMap').on('hidden.bs.collapse', function () {
        // redraw the map after it's panel has been opened (see also #340)
        mapstraction.resizeTo(jQuery('#mapContainer').width(), jQuery('#mapContainer').height());
    })
}

/**
 * Callback method for geocoding and geolocation functionality.
 */
function mUYourCityNewCoordinatesEventHandler() {
    var location = new mxn.LatLonPoint(jQuery("[id$='latitude']").val(), jQuery("[id$='longitude']").val());
    marker.hide();
    mapstraction.removeMarker(marker);
    marker = new mxn.Marker(location);
    mapstraction.addMarker(marker, true);
    mapstraction.setCenterAndZoom(location, defaultZoomLevel);
}

/**
 * Example method for initialising geo coding functionality in JavaScript.
 * In contrast to the map picker this one determines coordinates for a given address.
 * Uses a callback function for retrieving the address to be converted, so that it can be easily customised in each edit template.
 * There is also a method on PHP level available in the \MU\YourCityModule\Helper\ControllerHelper class.
 */
function mUYourCityInitGeoCoding(addressCallback)
{
    jQuery('#linkGetCoordinates').click(function (event) {
        mUYourCityDoGeoCoding(addressCallback);
    });
}

/**
 * Performs the actual geo coding using Mapstraction.
 */
function mUYourCityDoGeoCoding(addressCallback)
{
    var address = {
        address : jQuery('#street').val() + ' ' + jQuery('#houseNumber').val() + ' ' + jQuery('#zipcode').val() + ' ' + jQuery('#city').val() + ' ' + jQuery('#country').val()
    };

    // Check whether the given callback is executable
    if (typeof addressCallback === 'function') {
        address = addressCallback();
    }

    var geocoder = new mxn.Geocoder('googlev3', mUYourCityGeoCodeReturn, mUYourCityGeoCodeErrorCallback);
    geocoder.geocode(address);

    function mUYourCityGeoCodeErrorCallback (status) {
        if (status != 'ZERO_RESULTS') {
            mUYourCitySimpleAlert(jQuery('#mapContainer'), Translator.__('Error during geocoding'), status, 'geoCodingAlert', 'danger');
        }
    }

    function mUYourCityGeoCodeReturn (location) {
        jQuery("[id$='latitude']").val(location.point.lat.toFixed(7));
        jQuery("[id$='longitude']").val(location.point.lng.toFixed(7));
        mUYourCityNewCoordinatesEventHandler();
    }
}

/**
 * Callback method for geolocation functionality.
 */
function mUYourCitySetDefaultCoordinates (position) {
    jQuery("[id$='latitude']").val(position.coords.latitude.toFixed(7));
    jQuery("[id$='longitude']").val(position.coords.longitude.toFixed(7));
    mUYourCityNewCoordinatesEventHandler();
}

function mUYourCityHandlePositionError (event) {
    mUYourCitySimpleAlert(jQuery('#mapContainer'), Translator.__('Error during geolocation'), event.message, 'geoLocationAlert', 'danger');
}

/**
 * Initialises geographical editing features.
 */
function mUYourCityInitGeographicalEditing(latitude, longitude, mapType, zoomLevel, useGeoLocation)
{
    mUYourCityInitGeographicalDisplay(latitude, longitude, mapType, zoomLevel);

    // init event handler
    jQuery("[id$='latitude']").change(mUYourCityNewCoordinatesEventHandler);
    jQuery("[id$='longitude']").change(mUYourCityNewCoordinatesEventHandler);

    mapstraction.click.addHandler(function(eventName, eventSource, eventArgs) {
        var coords = eventArgs.location;
        jQuery("[id$='latitude']").val(coords.lat.toFixed(7));
        jQuery("[id$='longitude']").val(coords.lng.toFixed(7));
        mUYourCityNewCoordinatesEventHandler();
    });

    if (true === useGeoLocation) {
        // derive default coordinates from users position with html5 geolocation feature
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(mUYourCitySetDefaultCoordinates, mUYourCityHandlePositionError, {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 20000
            });
        }
    }

    /*
        Initialise geocoding functionality.
        In contrast to the map picker this one determines coordinates for a given address.
        To use this please customise the following method for assembling the address.
        Furthermore you will need a link or a button with id="linkGetCoordinates" which will
        be used by the script for adding a corresponding click event handler.

        var determineAddressForGeoCoding = function () {
            var address = {
                address : $('#street').val() + ' ' + $('#houseNumber').val() + ' ' + $('#zipcode').val() + ' ' + $('#city').val() + ' ' + $('#country').val()
            };

            return address;
        }

        mUYourCityInitGeoCoding(determineAddressForGeoCoding);
    */
}

jQuery(document).ready(function() {
    var infoElem;

    infoElem = jQuery('#geographicalInfo');
    if (infoElem.length == 0) {
        return;
    }

    if (infoElem.data('context') == 'display') {
        mUYourCityInitGeographicalDisplay(infoElem.data('latitude'), infoElem.data('longitude'), infoElem.data('map-type'), infoElem.data('zoom-level'));
    } else if (infoElem.data('context') == 'edit') {
        mUYourCityInitGeographicalEditing(infoElem.data('latitude'), infoElem.data('longitude'), infoElem.data('map-type'), infoElem.data('zoom-level'), infoElem.data('use-geolocation'));
    }
});
