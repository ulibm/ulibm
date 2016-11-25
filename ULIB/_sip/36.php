<?php  //พ
//this file copy from 63.php
//include ("../inc/config.inc.php");include ("./inc.php");

//$chkmem=tmq("select * from member where UserAdminID='".$dat["AA"]."' ");
$resp="36Y".
	$siptime.
	"AO".barcodeval_get("sipsetting-institutionID").$limiter.
	"AA".$dat["AA"].$limiter.
	"AF$limiter".
	"AG$limiter"
;
$PATRON="";
local_sput($resp);
?>