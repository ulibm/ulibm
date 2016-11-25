<?php 
include("../inc/config.inc.php");
$now=time();// พ
if ($clientid=="") {
	die("username=clientid_not_found&loadfinish=yes");
}
$newmem=trim($newmem);
if ($newmem!="") {
	$chk=tmq("select * from member where UserAdminID='$newmem' ");
	if (tmq_num_rows($chk)==1) {
		stathist_add("servspot_member",$newmem,$clientid);	
		tmq("update servicespot_client  set cu_loginid='$newmem',cu_regis='$now' where id='$clientid'");
	} else {
	die("username=membernotfound&loadfinish=yes");
	}
}
if ($clear=="yes") {
		tmq("update servicespot_client  set cu_loginid='' where id='$clientid'");
}
$s=tmq("select * from servicespot_client where id='$clientid' ");
$s=tmq_fetch_array($s);
echo "name=$s[name]&";
if ($s[cu_loginid]!="") {
	echo "nowdt=$now&";
	echo "cu_loginid=$s[cu_loginid]&";
	echo "cu_regisdt=$s[cu_regis]&";
	echo "username=".(strip_tags(get_member_name($s[cu_loginid])))."&";
} else {
	echo "nowdt=0&";
	echo "cu_loginid=0&";
	echo "cu_regisdt=0&";
	echo "username=--&";
}
if ($s[cu_loginid]!="") {
	echo "cu_regis=".ymd_datestr($s[cu_regis],"time")."&";
} else {
	echo "cu_regis=--&";
}
echo "loadfinish=yes";

?>