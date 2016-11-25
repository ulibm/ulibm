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

if ($mode=="setting") {
   include("inc.setting.php");
}
if ($mode=="syncdb") {
   include("inc.syncdb.php");
}
if ($mode=="folderupdate") {
   include("inc.folderupdate.php");
}
if ($savesettings=="yes") {
   barcodeval_set("addonssetting_libfullupgrade_url",$addonssetting_libfullupgrade_url);
}
$now=time();
pagesection("Upgrade ULib to latest version");
if ($_ISULIBMASTER=="yes") {
   html_dialog("message","Master site cannot update"); die;
}
html_dialog("Note",getlang("อัพเกรดทั้งระบบเป็นเวอร์ชันล่าสุด <BR>ใช้ในการอัพเกรดโครงสร้างฐานข้อมูลและไฟล์โปรแกรมจากเซิร์ฟเวอร์กลางที่ระบุไว้ในการตั้งค่า::l::Upgrade to latest version<BR>
for upgrading database structure and software files from source server specified in setting"));
?>
<table width=500 align=center><tr><td>
1. <a class='a_btn' href='index.php?mode=setting'> <?php echo getlang("ตั้งค่า::l::Settings");?></a><BR>
2. <a class='a_btn' href='index.php?mode=syncdb'> <?php echo getlang("อัพเกรด::l::Upgrade Database Structure");?></a><BR>
</td></tr></table><?php

foot();
?>