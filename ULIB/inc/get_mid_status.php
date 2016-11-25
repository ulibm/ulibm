<?php // พ
function get_mid_status($wh) {
	$s=tmq("select * from media_mid_status where code='$wh' ");
	$s=tmq_fetch_array($s);
	return "<FONT style='background-color:$s[col];' class=smaller2>".getlang($s[name])."</FONT>";
}
?>