define([
        'jquery',
        'ko',
        'jquery/ui',
        'mage/translate'
    ], function ($, ko) {
        'use strict';

        return function (config) {
            var self = this;

            self.initMarkers = function () {
                var locations = config['locations'];
                if (locations.length < 1) {
                    return;
                }

                var startPosition = {
                    lat: Number(locations[0]['latitude']),
                    lng: Number(locations[0]['longitude'])
                };

                var map = new google.maps.Map(
                    document.getElementById('map'), {
                        zoom: 7,
                        center: startPosition
                    }
                );

                for (var i = 0; i < locations.length; i++) {
                    self.addMarker(locations[i], map);
                }
            };

            self.addMarker = function (data, map) {
                var contentString = data['description'];
                var infoWindow = new google.maps.InfoWindow({content: contentString});
                var marker = new google.maps.Marker({
                    position: {lat: Number(data['latitude']), lng: Number(data['longitude'])},
                    title: data['title'],
                    map: map
                });

                marker.addListener('click', function () {
                    infoWindow.open(map, marker);
                });
            };

            self.initMarkers();
        }
    }
);