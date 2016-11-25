<?php  //พ
include("../../inc/config.inc.php");
$setw=floor($setw);
$seth=floor($seth);
$code="monitordisplay-$id";
if ($setw==0 || $seth==0) {
	?><!doctype html>
<html>
    <head>
	<style>
body {  
	margin: 0px  0px; 
	padding: 0px  0px; 
	background-color: #000000!important;
}
</style>
		<script src="jquery-1.11.0.js"></script>
		    </head>
    <body>
<script type="text/javascript">
	<!--
		window.location.replace("index.php?id=<?php  echo $id?>&seth="+$(window).height()+"&setw="+$(window).width())
	//-->
	</script>
	</body>
</html><?php 
	die;
}
?><!doctype html>
<html>
    <head>
		<script src="jquery-1.11.0.js"></script>
		<script src="galleria-1.3.5.js"></script>
			<style>
body {  
	margin: 0px  0px; 
	padding: 0px  0px; 
	background-color: #000000!important;
}
</style>
<style>
    .galleria{ width: <?php  echo $setw-20; ?>px; height: <?php  echo $seth-20; ?>px; background: #000000; }
</style>
    </head>
    <body>
<script>
   // $("body").text("jQuery works");
</script>
<script>
   // if (Galleria) { $("body").text('Galleria works') }
</script>

<center>
<div class="galleria"><?php 
$chk=tmq("select * from globalupload where keyid='".addslashes($code)."' and (
	hidename like '%.jpg'  or 
	hidename like '%.png'  or 
	hidename like '%.gif'  or 
	hidename like '%.jpeg'  	
	) ",false);
	//chk count
	if (tnr($chk)==0) { return;	}

	while ($r=tfa($chk)) {
		//printr($r);
		$imgurl=$dcrURL."_globalupload/$code/".$r[hidename];
		?>
    <img src="<?php echo $imgurl; ?>" data-title="<?php  echo $r[filename]?>" no-data-description="<?php  echo $r[filename]?>">

 <?php 
	}
?></div>



<script>
Galleria.configure({
    imageCrop: false,
    autoplay: true,
    transition: 'fade'
});
    Galleria.loadTheme('themes/classic/galleria.classic.min.js');
    Galleria.run('.galleria');

window.onresize = function(){ window.location.replace("index.php?id=<?php  echo $id?>&seth="+$(window).height()+"&setw="+$(window).width()); }

</script></center>
</body>
</html>