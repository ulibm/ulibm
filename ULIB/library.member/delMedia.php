<?php 
;
     include("../inc/config.inc.php"); 
loginchk_lib();

  echo $Sstr;
 if(!empty($ID))  
    {  
	   //ตรวจสอบค่าปรับ
  $sql1 ="SELECT *  FROM fine where memberId='$ID' and isdone='no'";
      $result = tmq($sql1);
	//echo $sql1;
    $NRow = tmq_num_rows($result);
	if ($NRow!=0) {
		//echo "ค่าปรับ $NRow";
		//จบตรวจสอบค่าปรับ
		echo "ไม่สามารถลบสมาชิก $ID สมาชิก $ID ยังมีค่าปรับ หากต้องการชำระ <a href='../circulation/index.php?loadfine=$ID'>คลิกที่นี่</a>";
		//echo $ID;
		die();
	}
  $sql1 ="SELECT *  FROM checkout where hold ='$ID' ";
      $result = tmq($sql1);
	//echo $sql1;
    $NRow = tmq_num_rows($result);
	if ($NRow!=0) {
		//echo "ค่าปรับ $NRow";
		//จบตรวจสอบค่าปรับ
		echo "ไม่สามารถลบสมาชิก $ID สมาชิก $ID ยังไม่ได้ส่งคืนวัสดุสารสนเทศที่ยืมไป จำนวน $NRow รายการ <A HREF='../library/holdlist.php?typeid=$ID'>คลิกที่นี่เพื่อตรวจดู</A>";
		//echo $ID;
		die();
	}
//die();
//ลบออกจากตารางขอยืม
/*
     $sql ="delete from request where  member_id ='$ID'" ;  
  if(tmq($sql)) {  
//   
	}  
    else {  
      echo"<font face ='ms sans serif'  size ='3'>";  
        echo "<b>Error </b> <br>ไม่สามารถลบข้อมูลออกจากข้อมูลการขอยืมได้";  
        echo"</font>";  
    }  
	*/
//ลบออกจากข้อมูลการจอง
    $sql = "update checkout set request='' where request='$ID'";
  if(tmq($sql)) {  
//   
	}  
    else {  
      echo"<font face ='ms sans serif'  size ='3'>";  
        echo "<b>Error </b> <br>ไม่สามารถลบข้อมูลออกจาข้อมูลการจองได้";  
        echo"</font>";  
    }  
//die();
tmq("delete from webpage_memfavbook where memid='$ID' ");
tmq("delete from webpage_memfavbook_perscate where memid='$ID' ");
tmq("insert into member_bin SELECT NULL,UserAdminID,UserAdminName,email,descr,type,address,address2,tel,prefi,dat,mon,yea,room,major,libsite,credit FROM `member` WHERE UserAdminID='$ID'") ;  
    
    
  $sql = "delete from member where UserAdminID='$ID'";
  if(tmq($sql)) {  
  
  
  		 $now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$ID',
edittype='delete member   '   ");



  echo"<font face ='ms sans serif'  size ='3'>";  
    echo"<div align=center><br><b>ทำการลบข้อมูลเรียบร้อยแล้ว</b><br></div>";  
  //echo"<meta http-equiv='refresh' content='0;URL=DBddal.php'>";  
	redir("DBddal.php?searchtype=$searchtype&keyword=$keyword",0);
    echo"</font>";  
       }  
    else {  
      echo"<font face ='ms sans serif'  size ='3'>";  
        echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";  
        echo"</font>";  
    }  
	die();
/////////////////////////////////////////////
} else {
      echo"<font face ='ms sans serif'  size ='3'>";  
        echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";  
        echo"</font>";  
}
echo $Estr;
?>