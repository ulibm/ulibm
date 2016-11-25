<?php 
    ;
include ("../inc/config.inc.php");
loginchk_lib('check');// พ

$_REQPERM="holdlong";
if (!library_gotpermission($_REQPERM)) {
	die('_REQPERM');
}

if ($goto=="annouce") {
	include("inc.annouce.php");
	die;
}
if ($goto=="notif") {
	include("inc.notif.php");
	die;
}
if ($goto=="emails") {
	if (barcodeval_get("mailsetting-isenable")!="yes") {
		die("Mail module disabled.");
	}
	include("inc.emails.php");
	die;
}
?>