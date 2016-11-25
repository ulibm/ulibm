<?php 
	; 
        include ("../inc/config.inc.php");
//html_start();

?>
                <div align = "center">
<?php 
pagesection(getlang("กำหนดตำแหน่งแผนที่::l::Edit Position"));
if ($issave=="yes") {
	barcodeval_set("webpage-o-gmapapiurl",$gmapapiurl);
	tmq("delete from webbox_box_googlemap where refid='$id' ");
	$now=time();
	tmq("insert into webbox_box_googlemap  set title='$title',lat='$lat',lng='$lng',refid='$id',dt=$now ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}
$s=tmq("select * from webbox_box_googlemap where refid='$id' ");
$s=tmq_fetch_array($s);
$defplace=$s[lat].",".$s[lng];
if (trim($defplace)==",") {
	$defplace="13.819244447544405,100.55623054504395";
}
?>
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php  echo barcodeval_get("webpage-o-gmapapiurl");?>" type="text/javascript"></script>
  <script type="text/javascript">
  function getobj(objid) {
	var ie=document.all&&navigator.userAgent.indexOf("Opera")==-1
	var dom=document.getElementById&&navigator.userAgent.indexOf("Opera")==-1
 
	if (ie||dom) {
		var iframeobj=document.getElementById? document.getElementById(objid) : eval("document.all."+objid)
	}
	return iframeobj;
 
}
 
<?php 
?>
  function initialize() {
    if (GBrowserIsCompatible()) {
	var mapOptions = {
		googleBarOptions : {
		  style : "new",
		}
	  }
        var map = new GMap2(document.getElementById("map_canvas"),mapOptions);
        var center = new GLatLng(<?php  echo $defplace;?>);
        map.setCenter(center, 10);
       map.setUIToDefault();
	  map.enableGoogleBar();

        var marker = new GMarker(center, {draggable: true});
        map.addOverlay(marker);
 
        GEvent.addListener(marker, "dragstart", function() {
          map.closeInfoWindow();
        });
 
        GEvent.addListener(marker, "dragend", function() {
		  var point = marker.getLatLng(); 
		  var lat = point.lat();
		  var lng = point.lng();
		 var latobj=getobj("lat"); latobj.value=lat;
		 var lngobj=getobj("lng"); lngobj.value=lng;
          //marker.openInfoWindowHtml(marker.getLatLng().toUrlValue());
        });
     }
}

/*
      var map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(13.819244447544405,100.55623054504395), 10);
      map.setUIToDefault();
      var marker = new GMarker(new GLatLng(13.819244447544405,100.55623054504395), {draggable: true});        
      map.addOverlay(marker);
  GEvent.addListener(marker, "dragstart", function() {
	  map.closeInfoWindow();
  });
		GEvent.addListener(marker, "dragend", function() {
		  var point = marker.getLatLng(); 
		  var lat = point.lat();
		  var lng = point.lng();
		 var latobj=getobj("lat"); latobj.value=lat;
		 var lngobj=getobj("lng"); lngobj.value=lng;
		  return true;
		});
	*/

</script>
</head>
<body onload="initialize()" onunload="GUnload()">
<div id="map_canvas" style="width: 800px; height: 500px"></div>
  <CENTER>
  <BR></CENTER>
<CENTER><FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>">
	Enter Google Maps API KEY <INPUT TYPE="text" NAME="gmapapiurl" ID=gmapapiurl value="<?php  echo barcodeval_get("webpage-o-gmapapiurl")?>"> 
	Lat: <INPUT TYPE="text" NAME="lat" ID=lat value="<?php  echo $s[lat]?>"> 
	Lng: <INPUT TYPE="text" NAME="lng" ID=lng value="<?php  echo $s[lng]?>"> <br>
	<?php echo getlang("ข้อความ::l::Title");?> <INPUT TYPE="text" NAME="title" ID="title" value="<?php  echo $s[title]?>" size=50> 
	<INPUT TYPE="submit" value="  บันทึก  " >

<input type=hidden name="issave" value="yes">
<input type=hidden name="locate" value="<?php  echo $locate;?>">
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</FORM>
</CENTER>

<BR>
  <?php  echo getlang("ลงทะเบียนได้ที่::l::Get Google Maps API key ");?> <A HREF="http://code.google.com/apis/maps/signup.html" target=_blank>http://code.google.com/apis/maps/signup.html</A>