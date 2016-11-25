<?php 
if (!function_exists("myencode")) {
function myencode($wh) {
	$wh=iconvth($wh);
	$r="";
	for ($i=0;$i<=strlen($wh);$i++) {
		if (ord(substr($wh,$i,1))>160 && ord(substr($wh,$i,1)) <=250) {
			$r.=":c".ord(substr($wh,$i,1))."";
		} else {
			$r.=":".ord(substr($wh,$i,1));
		}
	}
	return $r;
}
}
//echo ord("ฉ");
?>