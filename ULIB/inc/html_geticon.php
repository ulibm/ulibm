<?php // พ
function html_geticon($filename,$html="") {
	if ($html=="") {
		$html=" width=16 height=16 ";
	}
	global $dcrs;
	global $dcrURL;
	$ext=explode(".",$filename);
	$ext=$ext[count($ext)-1];
	$ext=strtolower($ext);
	//echo $ext;
	if (file_exists($dcrs."neoimg/filetype/$ext.png")) {
		$img=$dcrURL."neoimg/filetype/$ext.png";
	} else {
		$img=$dcrURL."neoimg/filetype/default.png";
	}
	$res="<img src='$img' $html border=0>";
	return $res;
}
?>