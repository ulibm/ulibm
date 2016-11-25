<?php // พ
function marc_getyea($wh,$sepper = "") {
	$tag=getval("search","yearfield_tagname");
	$tagsf=getval("search","yearfield_subfieldname");
	$tags=explode(",",$tag);
	$s=tmq("select * from media where ID='$wh' ");
	$s=tmq_fetch_array($s);
	$str="";
	while (list($key, $val) = each($tags)) {
		$str="$str " . substr($s[$val],2);
	}
	$res=dspmarc($str,$sepper);
	return $res;
}
?>