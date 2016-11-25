<?php 
include("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();

html_dialog("คำเตือน::l::Warning","ระบบนี้จะทำการอัพเดทรายการ Lang ของแท็ก 008 ด้วยข้อมูลจากประเภททรัพยากร<BR> เหมาะสำหรับใช้กับการปรับปรุงฐานข้อมูลเมื่อมีการนำเข้าข้อมูลจากระบบอื่นเท่านั้น::l::This module will update information in Lang (tag008) of Marc records <BR>to help improve database after import data from another structure");
?><center>
<a href="startreview.php" class=a_btn><?php  echo "Review" ?></a>
</center><?php 
foot();

?>