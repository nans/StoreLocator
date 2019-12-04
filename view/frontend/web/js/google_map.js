define([
        'jquery',
        'ko',
        'underscore'
    ], function ($, ko, _) {
        'use strict';

        return function (config) {
            var self = this;

            self.initMarkers = function () {
                var locations = config['locations'];
                if (locations.length < 1) {
                    return;
                }

                var firstElement = _.first(locations);
                var startPosition = {
                    lat: Number(firstElement['latitude']),
                    lng: Number(firstElement['longitude'])
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
                var contentString = self.applyDataByPattern(data, _.unescape(config['description_pattern']));
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

            self.applyDataByPattern = function (data, pattern) {
                var keys = _.keys(data);
                for (var i = 0; i < keys.length; i++) {
                    var currentKey = '{' + keys[i] + '}';
                    pattern = pattern.replace(currentKey, data[keys[i]]);
                }

                return pattern;
            };

            self.initMarkers();
        }
    }
);