<?php 
;
     include("../inc/config.inc.php");
loginchk_lib();


  echo $Sstr;
 if(!empty($ID)) {  
	 //startcheck
	$x="select * from authoritydb where ID='$ID' ";
	$x=tmq($x);
	if (tnr($x)!=1) {
		 html_dialog("","Error ผิดพลาด ไม่พบรายการที่ต้องการลบ");
		 foot();
		 die;
	}
	$x=tmq_fetch_array($x);
  //end check

     $sql ="delete from authoritydb where ID='$ID'" ;
     //echo $sql;

if(tmq($sql)) {  


		$typeid = urlencode($typeid);
		$faculty = urlencode($faculty);
		$keyword = urlencode($keyword);
		redir("DBbook.php?typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword",0);
	
} else {
	echo"<font face ='ms sans serif'  size ='3'>";
	echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
	echo"</font>";
}  
/////////////////////////////////////////////
} else { 
   echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล 
กรุณาใส่ข้อมูลให้เรียบร้อย ตรวจสอบอีกครั้ง";  
} 
echo $Estr;
?>