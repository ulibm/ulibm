<?php //พ
	include ("../inc/config.inc.php");
//html_start();
?><html>
<head>
<style>
body {
	margin: 0 0 0 0;
}
</style>
<title>Gmap display (uMedia)</title>
<?php  
$s=tmq("select * from  webbox_box_googlemap  where refid='$id' ");
$r=tmq_fetch_array($s);
//printr($r);
$defplace=$r[lat].",".$r[lng];
if (trim($defplace)==",") {
	$defplace="13.819244447544405,100.55623054504395";
}

	?>
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo barcodeval_get("webpage-o-gmapapiurl");?>" type="text/javascript"></script>
  <script type="text/javascript">
      function createMarker(point,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }
 

  function initialize() {
    if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        var center = new GLatLng(<?php echo $defplace?>);
        map.setCenter(center, 10);
       map.setUIToDefault();

		var point1 = new GLatLng(<?php echo $defplace?>);
		var marker = createMarker(point1,'<?php echo addslashes($r[title]);?>')
		map.addOverlay(marker);
} else {
	document.write("Sorry, your browse not support Google Maps");
	//alert("Sorry, your browse not support Google Maps");
}
  }

</script>
</head>
<body onload="initialize()" onunload="GUnload()">
<div id="map_canvas" style="width: 100%; height: 100%"></div>
</body>
</html>