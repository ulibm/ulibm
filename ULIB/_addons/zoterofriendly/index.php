<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
$now=time();
pagesection(getlang("zotero friendly"));
//int
?><center>Zoterao Friendly ไม่มีการตั้งค่าพิเศษ ระบบจะทำงานอัตโนมัติในหน้าแสดงรายการบรรณานุกรมทรัพยากรสารสนเทศ<br>
หากต้องการปรับแต่งการตั้งค่า MARC -  Dublin Core Crosswalk ทำได้ที่ การตั้งค่าตัวแปรระบบ ในหมวด CROSSWALK
</center><?php 
foot();
?>