<?php  //พ
if (!function_exists("havester_formatkeyid")) {
function havester_formatkeyid($wh) {
	global $newline;
	//copy this part to run-relcheck.php too
	//$wh=base64_decode($wh);
	$a=explode(":--:",$wh);
	$res="";
	@reset($a);
	$i=0;
	while (list($k,$v)=each($a)) {
		$i++;
		$tmp=marc_getsubfields($v,"no");
		if ($i==1) {
			$res.=$tmp[c].":";
		} else {
			$res.=$tmp[a].":";
		}
	}

	$wh=str_replace("\\","",$res);
	$wh=str_replace("/","",$wh);
	$wh=str_replace("'","",$wh);
	$wh=str_replace("\"","",$wh);
	$wh=str_replace("!","",$wh);
	$wh=str_replace("?","",$wh);
	$wh=str_replace(" ","",$wh);
	$wh=str_replace(".","",$wh);
	$wh=str_replace(",","",$wh);
	$wh=str_replace("^a","",$wh);
	$wh=str_replace("^b","",$wh);
	$wh=str_replace("^c","",$wh);
	$wh=str_replace("-","",$wh);
	$wh=str_replace("_","",$wh);
	$wh=str_replace("[","",$wh);
	$wh=str_replace("]","",$wh);
	$wh=str_replace("
","",$wh);
	$wh=str_replace($newline,"",$wh);
	$wh=str_replace(chr(13),"",$wh);
	//end copy
	return $wh;
}
}
?>