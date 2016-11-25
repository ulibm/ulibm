<?php 
    ;
	include ("../inc/config.inc.php");
	$_REQPERM="indexwordimportid";
	$tmp=mn_lib();
	pagesection($tmp);
	?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0"> 


    <tr valign="top"> 

      <td><font face="MS Sans Serif, Microsoft Sans Serif" size="2"> 

<?php  


	if ($ID=="[EMPTY]") {
		$ID="";
	}
     $sql ="delete from indexword where importdt='$ID'" ;  


    

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

/////////////////////////////////////////////

?> 

      </td> 

    </tr> 

  </table>