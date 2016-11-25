<?php // พ
function fft_upload_get($tb,$field,$key) {
	global $dcrURL;
	$key="$tb:$field:$key";
	$s=tmq("select * from fft_upload where keyid='$key' ",false);
	$res=Array();
	if (tmq_num_rows($s)==0) {
		$res[status]="notok";
		$res[url]="$dcrURL"."_tmp/fft_upload/unavailable.png";
	} else {
		$s=tmq_fetch_array($s);
		$res[status]="ok";
		$res[url]="$dcrURL"."_tmp/fft_upload/$tb/$s[hidename]";
	}
	return $res;
}
?>