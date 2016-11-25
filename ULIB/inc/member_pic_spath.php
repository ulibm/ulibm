<?php // พ
function member_pic_spath($useradminid) {
	global $dcrs;
	$place=barcodeval_get("memberpic-wheresave");
	if ($place=="local") {
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		return $dcrs."pic/$pref$useradminid$suff";
	} else {
		return "";
	}
}
?>