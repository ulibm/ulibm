<?php // พ
function marc_getsubfields($wh,$urlencode="yes") {
	$s=explodenewline($wh);
	$wh=$s[0];

	if (trim($wh)!="" && substr(trim($wh),0,1)!='^') {
		$wh='^a'.ltrim($wh);
	}

	$s=explode("^",$wh);
	$tmp=Array();
	//echo substr($wh,2,1);
	//echo $wh."<BR>";
	foreach ($s as $key => $value) {
		if (substr($value,0,1)<>'') {
			$tmp[substr($value,0,1)]=substr($value,1);
			if ($urlencode=="yes") {
				$tmp[substr($value,0,1)."_urlencode"]=urlencode(substr($value,1));
			}
		}
	}
	return $tmp;
}
?>