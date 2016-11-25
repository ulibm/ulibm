<?php  
;
include("../inc/config.inc.php");
loginchk_lib();

     $r=tmq("select * from weeklyclose");

	 $n =tmq_num_rows($r);

	 if ($n>5) {

	    echo "ไม่สามารถเพิ่มวันหยุดทำการให้ครบ 7 วันได้ (จะต้องมีวันทำการอย่างน้อย 1 วัน)<BR>

		กรุณาคลิกปุ่ม Back เพื่อกลับไปหน้าก่อนหน้า";

		die;

	 }

     $sql ="insert into weeklyclose (dat)";

     $sql.=" values ('$dat')";

       //echo $sql;
tmq($sql);
redir("media_type.php");?>