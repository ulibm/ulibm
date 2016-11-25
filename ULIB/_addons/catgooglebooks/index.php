<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
$now=time();
pagesection(getlang("Google Books"));
//int
?><center>การดึงข้อมูลหนังสือจาก Google Books ไม่มีการตั้งค่าพิเศษ ระบบจะแสดงปุ่มเพิ่มเติมในหน้าการคีย์ทรัพยากรใหม่แบบ MARC<br>
</center><?php 
foot();
?>