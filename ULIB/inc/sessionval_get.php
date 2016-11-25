<?php // พ
function sessionval_get($wh) {
	$sid=session_id();
	$now=time();
	$oldnow=$now-(60*60*24*1);
	$ct=addslashes($ct);
	tmq("delete from sessionval where dt<$oldnow ");

	$s=tmq("select * from sessionval where main='$wh' and sessionid='$sid' ");
	$s=tmq_fetch_array($s);
	return stripslashes($s[val]);
}
?>