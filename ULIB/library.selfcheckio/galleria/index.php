<?php  //พ
include("../../inc/config.inc.php");
$setw=floor($setw);
$seth=floor($seth);
sessionval_set("bcinlist","");
sessionval_set("bcoutlist","");
if ($setw==0 || $seth==0) {
	?><!doctype html>
<html>
    <head>
		<script src="jquery-1.11.0.js"></script>
		    </head>
    <body><script type="text/javascript">
	<!--
		window.location.replace("index.php?code=<?php  echo $code?>&seth="+$(window).height()+"&setw="+$(window).width())
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
    .galleria{ width: <?php  echo $setw-20; ?>px; height: <?php  echo $seth-20; ?>px; background: #000 }
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
$chk=tmq("select * from globalupload where keyid='selfcheckio-".addslashes($code)."' and (
	hidename like '%.jpg'  or 
	hidename like '%.png'  or 
	hidename like '%.gif'  or 
	hidename like '%.jpeg'  	
	) ",false);
	//chk count
	if (tnr($chk)==0) { return;	}

	while ($r=tfa($chk)) {
		//printr($r);
		$imgurl=$dcrURL."_globalupload/selfcheckio-$code/".$r[hidename];
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
</script></center>
</body>
</html>