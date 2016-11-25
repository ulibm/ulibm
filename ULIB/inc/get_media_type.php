<?php // พ
function get_media_type($wh) {
	$s=tmq("select * from media_type where code='$wh' ");
	$s=tmq_fetch_array($s);
	return getlang($s[name]);
}
?>