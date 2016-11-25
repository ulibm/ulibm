<?php 

;

     include("../inc/config.inc.php"); 

loginchk_lib();

 if(!empty($ID))  

    {  

       

     $sql ="delete from media_mid where id='$ID'" ;  

    

  if(tmq($sql)) {  

	redir("media_type.php?sid=$sid&MID=$MID&remotes_row=$remotes_row");
  echo"<font face ='ms sans serif'  size ='3'>";  

    echo"<div align=center><br><b>ทำการลบข้อมูลเรียบร้อยแล้ว</b><br></div>";  


    echo"</font>";  

	$now=time();

		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$MID',
		edittype='delete item id=$ID barcode=$barcodeforlog'		");
		}  

    else {  

      echo"<font face ='ms sans serif'  size ='3'>";  

        echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";  

        echo"</font>";  

    }  

/////////////////////////////////////////////

}

?> 