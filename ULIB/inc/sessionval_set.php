<?php // พ
function sessionval_set($wh,$ct) {
	$sid=session_id();
	$now=time();
	global $loginadmin;
	global $useradminid;
	global $_memid;
	global $IPADDR;
	$ct=addslashes($ct);

	tmq("delete from sessionval where main='$wh' and sessionid='$sid' ");
	tmq("insert into sessionval set
	sessionid='$sid',
	descr='loginadmin=$loginadmin,useradminid=$useradminid,memid=$_memid',
	main='$wh',
	dt='$now',
	ipset='$IPADDR',
	val='$ct'
	");

}
?>