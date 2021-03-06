// Preloader
function showLoading() {
  $("#loading").show();
};

function hideLoading() {
  $("#loading").hide();
};


var map;

// Create a div to hold the control.
var controlDiv = document.createElement('div');

function LocationControl(controlDiv, map) {

  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#fff';
  controlUI.style.border = '2px solid #fff';
  controlUI.style.borderRadius = '3px';
  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
  controlUI.style.cursor = 'pointer';
  controlUI.style.marginBottom = '22px';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Cliquer pour vous localiser sur la carte';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.color = 'rgb(25,25,25)';
  controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.style.lineHeight = '38px';
  controlText.style.paddingLeft = '5px';
  controlText.style.paddingRight = '5px';
  controlText.innerHTML = 'Ma position';
  controlUI.appendChild(controlText);

  // Setup the click event listeners
  controlUI.addEventListener('click', function() {

    showLoading();
    navigator.geolocation.getCurrentPosition(handle_geolocation_query,handle_errors);

        function handle_errors(error)
        {
            switch(error.code)
            {
                case error.PERMISSION_DENIED: alert("user did not share geolocation data");
                break;

                case error.POSITION_UNAVAILABLE: alert("could not detect current position");
                break;

                case error.TIMEOUT: alert("retrieving position timed out");
                break;

                default: alert("unknown error");
                break;
            }
            hideLoading();
        }

        function handle_geolocation_query(position){

            var infoWindow = new google.maps.InfoWindow({map: map});

            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            infoWindow.setPosition(pos);
            infoWindow.setContent('Localisation actuelle :)');
            map.setCenter(pos);
            map.setZoom(12);
            hideLoading();

        }
  });
};  

function initMap() {

  var styledMapType = new google.maps.StyledMapType(        
        [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#523735"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#c9b2a6"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#dcd2be"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#ae9e90"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#93817c"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#a5b076"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#447530"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#fdfcf8"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f8c967"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#e9bc62"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e98d58"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#db8555"
      }
    ]
  },
  {
    "featureType": "road.local",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#806b63"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8f7d77"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#b9d3c2"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#92998d"
      }
    ]
  }
  ],
  {name: 'N.A.O.'});


  map = new google.maps.Map(document.getElementById('map-observe'), {
    center: {lat: 46.626699, lng: 2.646070},
    zoom: 7,
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        mapTypeIds: ['n.a.o.','roadmap','satellite','terrain']
    }
  
  });

  map.mapTypes.set('n.a.o.', styledMapType);
  map.setMapTypeId('n.a.o.');
  
  // LocationControl
  var locationControlDiv = document.createElement('div');
  var locationControl = new LocationControl(locationControlDiv, map);

  map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locationControlDiv);

  // Marker
  if (observations != undefined) {
    for(var index in observations) {
      /*var infoWindow = new google.maps.InfoWindow({map: map});*/
      var posObs = new google.maps.LatLng(observations[index].lat, observations[index].lng);
      var infoWindow = new google.maps.InfoWindow({map: map});

      /*infoWindow.setPosition(pos);
      infoWindow.setContent('<img src="' + observations[index].img + '" style="width: 200px;">');*/
      var cityCircle = new google.maps.Circle({
        strokeColor: '#55CADB',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#254460',
        fillOpacity: 0.35,
        map: map,
        center: posObs,
        radius: Math.sqrt(observations[index].nbr) * 10000
      });

      /* Map events */
      google.maps.event.addListener(cityCircle,"mouseover",function(){
        infoWindow.setMap(map);
        infoWindow.setPosition(posObs);
        infoWindow.setContent('<img src="/' + observations[index].img + '" style="width: 300px;height: 200px;">');
      }); 

      google.maps.event.addListener(cityCircle,"mouseout",function(){
        infoWindow.setMap(null);
      });
    }
  }
};
