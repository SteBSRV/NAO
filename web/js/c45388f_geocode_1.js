var geocoder;
var map;

function initialize() {
	geocoder = new google.maps.Geocoder();
}

function codeAddress() {
	var addressRoad = document.getElementById('observation_address_address');
	var postalCode = document.getElementById('observation_address_postalCode');
	var cityName = document.getElementById('observation_address_city');

	if (addressRoad.value != "" && postalCode.value != "" && cityName.value != "") {
		var address = addressRoad.value;
		console.log(address);

		address += ', ' + postalCode.value;
		address += ' ' + cityName.value;
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == 'OK') {
			document.getElementById('observation_address_lat').value = results[0].geometry.location.lat();
			document.getElementById('observation_address_lng').value = results[0].geometry.location.lng();
		} else {
			alert('Geocode was not successful for the following reason: ' + status);
		}
	});
}
}

function geocodeLocalisation() {
	initiate_geolocation();
	alert('Calcul de la position en cours, veuillez patienter...');
}

function initiate_geolocation() {
    navigator.geolocation.getCurrentPosition(handle_geolocation_query,handle_errors);
}

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
}

function handle_geolocation_query(position){
    handleAddressForm(position);
}

function handleAddressForm(position) {
	var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};

	geocoder.geocode({'location': latlng}, function(results, status) {
		if (status === 'OK') {
			if (results[1]) {
				var addressRoad = results[0].address_components[0].long_name + ', ' + results[0].address_components[1].long_name;
				var postalCode = results[0].address_components[6].long_name;
				var cityName = results[0].address_components[2].long_name;

				document.getElementById('observation_address_address').value = addressRoad;
				document.getElementById('observation_address_postalCode').value = postalCode;
				document.getElementById('observation_address_city').value = cityName;
				document.getElementById('observation_address_lat').value = position.coords.latitude;
				document.getElementById('observation_address_lng').value = position.coords.longitude;
			} else {
				window.alert('Aucun coordonnées correspondant à l\'adresse');
			}
		} else {
		  	window.alert('Impossible de récupérer les coordonnées correspondant à l\'adresse : ' + status);
		}
	});
}
