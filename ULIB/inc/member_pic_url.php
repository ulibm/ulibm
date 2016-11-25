<?php // พ
function member_pic_url($useradminid) {
	global $dcrURL;
	global $dcrs;
	$place=barcodeval_get("memberpic-wheresave");
	//echo "[$place/$dcrURL]";
	if ($place=="local") {
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		return $dcrURL."pic/$pref$useradminid$suff";
	} else {
		$suff=barcodeval_get("memberpic-global-suffix");
		$pref=barcodeval_get("memberpic-global-prefix");
		return "$pref$useradminid$suff";
	}
}
?>