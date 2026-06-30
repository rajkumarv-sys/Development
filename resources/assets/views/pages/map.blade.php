<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="./maps/togeojson.js"></script>
  <script src="./maps/tooltip.js"></script>

  <title>BrandIdeaMAP</title>
  <style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
      height: 768px;
      /*	width: 1000px;*/
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    #description {
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
    }

    #infowindow-content .title {
      font-weight: bold;
    }

    #infowindow-content {
      display: none;
    }

    #map #infowindow-content {
      display: inline;
    }

    .pac-card {
      margin: 10px 10px 0 0;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      background-color: #fff;
      font-family: Roboto;
    }

    #pac-container {
      padding-bottom: 12px;
      margin-right: 12px;
    }

    .pac-controls {
      display: inline-block;
      padding: 5px 11px;
    }

    .pac-controls label {
      font-family: Roboto;
      font-size: 13px;
      font-weight: 300;
    }

    #pac-input {
      background-color: #fff;
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
      margin-left: 12px;
      padding: 0 11px 0 13px;
      text-overflow: ellipsis;
      width: 400px;
    }

    #pac-input:focus {
      border-color: #4d90fe;
    }

    #title {
      color: #fff;
      background-color: #4d90fe;
      font-size: 25px;
      font-weight: 500;
      padding: 6px 12px;
    }

    #target {
      width: 345px;
    }

    .legend1 {
      text-align: left;
      /* width: 200px; */
      line-height: 18px;
      color: #000;
      /*background-color:white;*/
      /*height:40px;
  width:50px;*/
    }

    .circle {
      float: left;
      width: 20px;
      height: 9px;
      margin: 5px 5px 0 0;
      border: 1px solid rgba(0, 0, 0, .2);
    }
  </style>
</head>

<body>

  <div id="map"></div>

  <script>
    var valuesar = [];
    var colorsar = [];

    var myStyle = [

      {
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "administrative",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "landscape.natural",
        "stylers": [{
            "color": "#000000"
          },
          {
            "visibility": "on"
          }
        ]
      },
      {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "transit",
        "elementType": "labels.icon",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "water",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }

    ];


    function initAutocomplete() {

      //var minZoomLevel = 10;
      var opt = {
        minZoom: 0,
        maxZoom: 21
      };
      var map = new google.maps.Map(document.getElementById('map'), {
        mapTypeControlOptions: {
          mapTypeIds: ['mystyle', google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID]
        },
        center: {
          lat: 28.723960,
          lng: 77.156964
        },
        zoom: 2,
        zoomControl: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
          position: google.maps.ControlPosition.RIGHT_BOTTOM
        },
        mapTypeId: 'mystyle'
      });

      map.setOptions(opt);

      map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, {
        name: 'My Style'
      }));
      // Create the search box and link it to the UI element.
      var input = document.getElementById('pac-input');
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      var markers = [];
      // Listen for the event fired when the user selects a prediction and retrieve
      // more details for that place.
      searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
          }));

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      });

    
      $.ajax("./maps/KML/1---21---21.kml").done(function(xml) {
        conversion = toGeoJSON.kml(xml);
        layer = map.data.addGeoJson(conversion);
        //console.log(conversion);
      });

      map.data.setStyle(function(feature) {
        // testtt++;
        return ({
          strokeColor: '#000000',
          strokeOpacity: 0.8,
          strokeWeight: 1,
          fillColor: '#ffffff',
          //strokePosition:
          zindex: 0,
          //fillColor: colorcodeid[feature.getProperty('DB_ID')],
          fillOpacity: 1
        });
      });


      map.data.addListener('dblclick', function(event, feature) {

        var str1 = event.feature.getProperty('DB_ID');
        alert(str1);
        if (str1 == "1") {
          file = "./maps/KML/1---21---1.kml";
        } else if (str1 == "111") {
          file = "./maps/KML/1---5---5.kml";
        } else {
          file = "./maps/KML/1---21---21.kml";
        }

       
        //
        //alert("yesssssssssssss");
        // if (file == "./maps/KML/1---21---21.kml") {
        //   file = "";
        //   file = "./maps/KML/1---21---1.kml";
        // }

        $.ajax(file).done(function(xml) {
          conversion = toGeoJSON.kml(xml);
          layer = map.data.addGeoJson(conversion);
          console.log(conversion);
        });


      });

    }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6xJLF1r0jCwFxFaL-zDvRDgCl8Ogo1tk&libraries=places,drawing&callback=initAutocomplete" async defer></script>

</body>

</html>