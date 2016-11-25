<?php 
include ("../inc/config.inc.php");

$_GLOBAL_UPLOADSIZE=1000000000000000000000000; //bytes

	//special

$_VAL_FILE_SAVEPATH=$webpageboarddcrs."/_files/";
$_VAL_FILE_SAVEPATHurl=$webpageboarddcrURL."_files/";
$_VAL_FILE_SAVEPATHunused=$webpageboarddcrs."/_unusedfiles/";

$_topicstatus["protection"]=" TITLE='".getlang("ไม่มีสิทธิ์เข้าชม::l::Disallow to view")."' ";
$_topicstatus["green"]=" TITLE='".getlang("มีข้อความใหม่::l::New message")."' ";
$_topicstatus["gray"]=" TITLE='".getlang("ไม่มีข้อความใหม่::l::No new message")."' ";
$_topicstatus["red-small"]=" TITLE='".getlang("มีข้อความใหม่::l::New message")."' ";
$_topicstatus["green-small"]=" TITLE='".getlang("ไม่มีข้อความใหม่::l::No new message")."' ";

?>