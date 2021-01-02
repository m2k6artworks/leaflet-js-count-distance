<?php
	require_once __DIR__ . '/vendor/autoload.php';

	use function Geodistance\centimeters;
	use function Geodistance\feet;
	use function Geodistance\kilometers;
	use function Geodistance\miles;
	use function Geodistance\meters;
	use function Geodistance\yards;
	use Geodistance\Location;
	
	if (isset($_POST['ajax']))
	{
		$long = $_POST['long'];
		$lat = $_POST['lat'];

		// shop coordinate
		$shop = new Location(-7.565790799999999, 110.81719009999999);

		$destination = new Location($lat, $long);

		$decimal_precision = 1;

		// $kilometers = centimeters($shop, $destination, $decimal_precision);
		// $kilometers = feet($shop, $destination, $decimal_precision);
		// $kilometers = meters($shop, $destination, $decimal_precision);
		// $kilometers = yards($shop, $destination, $decimal_precision);
		// $kilometers = miles($shop, $destination, $decimal_precision);
		$kilometers = kilometers($shop, $destination, $decimal_precision);
		
		$fee = number_format(1500*round($kilometers), 0,',','.');
		$stuff = array($fee, $kilometers);
		
		foreach ($stuff as $value) {
    		echo $value, " ";
		}

		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="leaflet/leaflet.js"></script>
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<style type="text/css">
	 	#mapid {
		  	margin: 0 auto 0 auto;
		  	height: 65%;
		  	width: 80%;
	 	}

	 	html, body {
	        height: 100%;
	    }
	</style>
</head>
<body>
	<center>
	<b>Sub-District / District / City</b>
	<div id="search">
		<input type="text" name="inputAddress" id="inputAddress" 
		placeholder="Timuran Banjarsari Surakarta" size="58" />
		<button type="button" id="button">Search</button>
			<p>
				<input type="hidden" name="lat" id="lat" required placeholder="latitude">
	    		<input type="hidden" name="long" id="long" required placeholder="longtitude">
	    	</p>
		<div id="jarak"><h3>Click on the map to set the shipping location</h3></div>
		<div>
			<button id="resetLocation">Set to My Current Position</button>
		</div>
		 <script>

  		</script>
	</div>
	<br>
	</center>
	<div id="mapid" >
	</div>
		<script type="text/javascript">

			let userCoords = [];
			let theMarker = {};

			// mendapatkan lokasi user menggunakan geolocation api
			const getUserCurrentLoc = () => {
				if (navigator.geolocation) 
				{
					// navigator.geolocation.watchPosition(position => {
					navigator.geolocation.getCurrentPosition(position => {
						getCurrents = [position.coords.latitude, position.coords.longitude];
						userCoords.push(getCurrents[0], getCurrents[1]);
						renderMaps(getCurrents[0], getCurrents[1]);
					})
				} 
				else 
				{
					console.error("Your Browser doesn't support location access! Please use latest Web Browser instead");
					alert("Your Browser doesn't support location access! Please use latest Web Browser");
				}
			}

			// render peta
			const renderMaps = (lats, lons) => {

				const mapOptions = {
					center: [lats, lons],
					zoom: 13
				}

				const map = new L.map('mapid', mapOptions);

				const layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
				map.addLayer(layer);

				const homeIcon = L.icon({
					iconUrl: 'icon/home.png',
					iconSize: [40, 45],
					iconAnchor:   [24, 44],
					popupAnchor:  [-3, -15] // size of the icon
				});

				L.marker([lats, lons], {icon: homeIcon}).addTo(map).bindPopup("Warehouse");

				//mencari alamat spesifik lalu mengganti tampilan peta
				$('#button').click(function() {
					let rawAddress = document.getElementById("inputAddress").value;
					let formatAddress = rawAddress.replace(' ', '%20');
					let xmlhttp = new XMLHttpRequest();
					let url = `https://nominatim.openstreetmap.org/search?format=json&q=${formatAddress}`;
					xmlhttp.onreadystatechange = function()
					{		
						if (this.readyState == 4 && this.status == 200)
						{
							let data = JSON.parse(this.responseText);
							lats = parseFloat(data[0].lat);
							lons = parseFloat(data[0].lon);
							map.setView([lats, lons], 15);
						}
					};
					xmlhttp.open("GET", url, true);
					xmlhttp.send();
				});

				map.on('click',function(e) {
					let lat = e.latlng.lat;
					let lon = e.latlng.lng;

					//console.log("You clicked the map at LAT: "+ lat+" and LONG: "+lon );
					document.getElementById('lat').value = lat;
					document.getElementById('long').value =  lon;

					locationMarker(map, lat, lon);
				
				});

				// Memindah koordinat tujuan ke koordinat user
				$('#resetLocation').click(function() {
					locationMarker(map, userCoords[0], userCoords[1]);
				});

			}

			// menampikan marker lokasi pengiriman
			const locationMarker = (map, lats, lons) => {

				//Icon marker
				const destIcon = L.icon({
					iconUrl: 'icon/destination.png',
					iconSize: [40, 45],
					iconAnchor:   [24, 44],
					popupAnchor:  [-3, -15] // size of the icon
				});

				//Menghapus marker yang sudah ada,
				if (theMarker != undefined) {
					map.removeLayer(theMarker);
				};
				
				//Menampilkan marker.
				theMarker = L.marker([lats,lons], {icon: destIcon}).addTo(map).bindPopup("Destination");
				map.setView([lats, lons], 15);
				
				//Menampilkan ongkir
				$(theMarker).ready(function(){
					let lat = lats;
					let long = lons;
					let fee;

					$.ajax({
						type: 'post',
						data: {ajax: 1, long: long, lat: lat, fee: fee},
						success: function(response) {
							const value = response.split(" ");
							if(value[0] == 0)
								valueFix = 'Free';
							else
								valueFix = `IDR ${value[0]}`;
							$('#jarak').html(`
							<h3>Delivery Fee : ${valueFix} </h3>
							<h3>Distance : ${value[1]} km </h3>`);
						}
					});
				});
			}	

			getUserCurrentLoc();

/*				let name;

				$.ajax({
	  				dataType: "json",
	  				url: `https://nominatim.openstreetmap.org/search?format=json&q=${formatAddress}`,
	  				data: {'name':name},
	  				success: function(data) {
						lats = parseFloat(data[0].lat);
						lons = parseFloat(data[0].lon);
					}
				});
				*/

/*				$.getJSON(`https://nominatim.openstreetmap.org/search?format=json&q=${formatAddress}`).then(function(data) {
					console.log(data);
						lats = parseFloat(data[0].lat);
						lons = parseFloat(data[0].lon);
						map.setView([lats, lons],15);
					});*/
		</script>
</body>
</html>