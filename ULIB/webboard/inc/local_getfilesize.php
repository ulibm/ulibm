<?php 
function local_getfilesize($wh) {
	global $_VAL_FILE_SAVEPATH;
	$wh2=$_VAL_FILE_SAVEPATH."$wh";
	//echo $wh2;
	if (file_exists($wh2)) {
		return number_format(filesize($wh2)/1024)." kb";
	} else {
		return " ไม่พบไฟล์ ";
	}
}
?>