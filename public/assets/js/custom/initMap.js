var marker;
var map;
var infowindow;
var address = ''

function initMap() {
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: {lat: 29.3117, lng: 47.4818},
        zoom: 8
    });
    //var card = document.getElementById('pac-card');
    var input = document.getElementById('address');
    // map.controls[google.maps.ControlPosition.TOP_CENTER].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Set the data fields to return when the user selects a place.
    autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name']);

    infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {

            map.fitBounds(place.geometry.viewport);
        } else {

            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        address = '';
        country = '';
        country_code = '';
        if (place.address_components) {
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] === 'country') {
                    country = place.address_components[i].long_name;
                    country_code = place.address_components[i].short_name;

                }
            }


            address = [
                (place.address_components[0] && place.address_components[0].long_name || ''),
                (place.address_components[1] && place.address_components[1].long_name || ''),
                (place.address_components[2] && place.address_components[2].long_name || ''),
                (place.address_components[3] && place.address_components[3].long_name || ''),
                (place.address_components[4] && place.address_components[4].long_name || ''),
                (place.address_components[5] && place.address_components[5].long_name || ''),
                (place.address_components[6] && place.address_components[6].long_name || ''),
                (place.address_components[7] && place.address_components[7].long_name || ''),
                (place.address_components[8] && place.address_components[8].long_name || '')
            ].join(' ');
        }

        google.maps.event.addListener(marker, 'click', function () {
            if (marker.formatted_address) {
                infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));

                $("#address").val(marker.formatted_address);

                $("#pac-input").val(marker.formatted_address);

            } else {
                infowindow.setContent(address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                $("#address").val(address);

                $("#pac-input").val(address);
            }
            $("#latitude").val(marker.getPosition().lat());
            $("#longitude").val(marker.getPosition().lng());
            infowindow.open(map, marker);
        });
        google.maps.event.trigger(marker, 'click');

        google.maps.event.addListener(marker, 'dragend',
            function () {
                geocodePosition(marker.getPosition());
                //console.log(marker.getPosition().toUrlValue(6));
                if (marker.formatted_address) {
                    infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                    $("#address").val(marker.formatted_address);
                    $("#pac-input").val(marker.formatted_address);

                } else {
                    infowindow.setContent(address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                    $("#address").val(address);
                    $("#pac-input").val(address);
                }
                $("#latitude").val(marker.getPosition().lat());
                $("#longitude").val(marker.getPosition().lng());

                infowindow.open(map, marker);
            }
        );
    });
}

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function (responses) {
        if (responses && responses.length > 0) {
            marker.formatted_address = responses[0].formatted_address;
        } else {
            marker.formatted_address = 'Cannot determine address at this location.';
        }
    });
}

$('#address').keydown(function (e) {
    if (e.which === 13 && $('.pac-container:visible').length) return false;
});

function addMarker(lat, long, location) {
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, long),
        draggable: true,
        animation: google.maps.Animation.DROP,
        map: map
    });
    map.setCenter(new google.maps.LatLng(lat, long));
    map.setZoom(17);

    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(location);
        infowindow.open(map, marker);
    });

    google.maps.event.addListener(marker, 'select', function () {
        infowindow.setContent(location);
        infowindow.open(map, marker);
    });

    google.maps.event.addListener(marker, 'dragend',
        function () {
            geocodePosition(marker.getPosition());
            //console.log(marker.getPosition().toUrlValue(6));
            if (marker.formatted_address) {
                infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                $("#address").val(marker.formatted_address);
                $("#pac-input").val(marker.formatted_address);

            } else {
                infowindow.setContent(address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
                $("#address").val(address);
                $("#pac-input").val(address);
            }
            $("#latitude").val(marker.getPosition().lat());
            $("#longitude").val(marker.getPosition().lng());

            infowindow.open(map, marker);
        }
    );
}
