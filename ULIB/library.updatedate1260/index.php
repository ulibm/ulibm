<?php 
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();

html_dialog("คำเตือน::l::Warning","ระบบนี้จะทำการอัพเดทรายการ Date1 ของแท็ก 008 ด้วยข้อมูลจากแท็ก 260^c เฉพาะรายการที่ยังไม่มีข้อมูลใน Date1  <BR> เหมาะสำหรับใช้กับการปรับปรุงฐานข้อมูลเมื่อมีการนำเข้าข้อมูลจากระบบอื่นเท่านั้น::l::This module will update information in Date1 of Marc records which Date1 is empty<BR>to help improve database after import data from another structure");
?><center>
<a href="startreview.php" class=a_btn><?php  echo "Review" ?></a>
</center><?php 
foot();

?>