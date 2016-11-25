<?php // พ
function marc_getserialdat($wh) {
	$tag=getval("MARCdsp",'serialstore');
	$tags=explode(",",$tag);
	$s=tmq("select * from media where ID='$wh' ");
	$s=tmq_fetch_array($s);
	$str="";
	while (list($key, $val) = each($tags)) {
		$str="$str\n" . substr($s[$val],2);
	}
	$str=str_replace("\n\n","\n",$str);
	return $str;
}
?>