<?php 
    ;
	include ("../inc/config.inc.php");
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);
	?>

  <table width="780" align=center border="0" cellspacing="0" cellpadding="0"> 

    <tr valign="top"> 

      <td>

<?php  



 if(!empty($ID))  

    {  

       

     $sql ="delete from bkedit where id='$ID'" ;  

    

  if(tmq($sql)) {  

  echo"<font face ='ms sans serif'  size ='3'>";  

    echo"<div align=center><br><b>ทำการลบข้อมูลเรียบร้อยแล้ว</b><br></div>";  

  echo"<meta http-equiv='refresh' 

content='0;URL=media_type.php?sid=$sid'>";  

    echo"</font>";  

       }  

    else {  

      echo"<font face ='ms sans serif'  size ='3'>";  

        echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";  

        echo"</font>";  

    }  

	}
?>