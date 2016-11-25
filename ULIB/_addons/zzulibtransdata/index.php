<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("info.php");
head();
@mkdir("_tmp");@mkdir("_tmpe");
include("../chkpermission.php");
include("../menu.php");
include("func.php");
include("archive.php");
$tblist=tmq("show tables");
$t=Array();
while ($r=tmq_fetch_array($tblist)) {
	$t[]=$r[0];
}
//echo $dbname;
//print_r($t);
?><center><?php
if ($mode=="folderupdate") {
   include("inc.folderupdate.php");
}
if ($mode=="setting") {
   include("inc.setting.php");
}
if ($savesettings=="yes") {
   barcodeval_set("addonssetting_ulibtransdata_url",$addonssetting_ulibtransdata_url);
}
$now=time();
pagesection("Files and Fulltext retriever");
html_dialog("Note",getlang("ระบบช่วยดึงข้อมูล Fulltext และไฟล์ที่อัพโหลด <BR>จากเซิร์ฟเวอร์หรือโปรแกรมตัวเดิม ใช้ช่วยในการโอนไฟล์เมื่อมีการย้ายโปรแกรม::l::File and Fulltext retriever<BR>
help transfer files and fulltext from another copy of ULib. "));
?>
<center><?php 
echo getlang("จะต้องนำ PHP ไฟล์ต่อไปนี้ไปวางไว้ที่โฟลเดอร์หลักของโปรแกรมตัวเดิม ::l::Need to put this PHP file in the main folder of source ULib");
echo "<a href='_ULIBTRANSDATA.zip'>_ULIBTRANSDATA.zip</a>";
?><BR><BR>

<table width=500 align=center><tr><td>
1. <a class='a_btn' href='index.php?mode=setting'> <?php echo getlang("ตั้งค่า::l::Settings");?></a><BR>
2. <a class='a_btn' href='index.php?mode=folderupdate'> <?php echo getlang("เริ่มดึงข้อมูล::l::Start Transfer");?></a><BR>
</td></tr></table><BR><BR>

<center><?php

$tmp=barcodeval_get("addonssetting_ulibtransdata_url");
if ($tmp!="") {
	echo "<font class=smaller>URL=<a href='$tmp' target=_blank>$tmp</a></font>";
}

foot();
?>