<?php // พ
function marc_gettitle($wh) {
	global $newline;
	$tag=getval("MARCdsp","titletag");
	$tags=explode(",",$tag);
	$s=tmq("select * from media where ID='$wh' ",false);
	$s=tmq_fetch_array($s);
	$str="";
	while (list($key, $val) = each($tags)) {
		$str="$str " . substr($s[$val],2);
	} //printr($s);
	//echo "[$wh-$tag=$str]";
	$str=str_replace($newline,'',$str);
	$str=explodenewline($str);
	$str=$str[0];
	return dspmarc($str);
}
?>