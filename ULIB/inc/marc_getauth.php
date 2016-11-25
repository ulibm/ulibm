<?php // พ
function marc_getauth($wh) {
	$tag=getval("MARCdsp","authtag");
	$tags=explode(",",$tag);
	$s=tmq("select * from media where ID='$wh' ");
	$s=tmq_fetch_array($s);
	$str="";
	while (list($key, $val) = each($tags)) {
		$str="$str " . substr($s[$val],2);
	}
	return dspmarc($str);
}
?>