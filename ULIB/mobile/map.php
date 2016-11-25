
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
	  <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { width: 480px; height: 400px; }
    </style>

</head> 
<body>
  <div id="map" style="width: 100%; height: 100%;"></div>

  <script type="text/javascript">
      var locations = [
      ['สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม', 16.246814, 103.250688, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(16.246814, 103.250688),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

	google.maps.event.trigger(map, 'resize');
	map.setCenter(new google.maps.LatLng( 16.246814, 103.250688));

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

	function setcen() {
		map.setCenter(new google.maps.LatLng(14.149725835290086,100.60017585754395));
	}
	//setTimeout("setcen()",1000);
  </script>
</body>
</html>