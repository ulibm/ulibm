<?php // พ
function frm_globalupload($wh,$addtotextarea="") {
	global $dcrURL;
	$wh=trim($wh);
	$wh=urlencode($wh);
	if ($wh=='') {
		die("frm_globalupload() need key ($wh)");
	}
	$addtotextarea=urlencode($addtotextarea);
	?><iframe width=100% height=200 src="<?php  echo $dcrURL?>/globalupload.php?key=<?php echo $wh?>&addtotextarea=<?php  echo $addtotextarea;?>"></iframe><?php 
}
?>