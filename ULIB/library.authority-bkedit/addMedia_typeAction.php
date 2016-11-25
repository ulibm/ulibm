<?php  
    ;
	include ("../inc/config.inc.php");
	include("_REQPERM.php");
mn_lib();
	?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">

    <tr valign="top"> 

      <td>
        <?php  

    // คำสั่งบันทึกลงฐานข้อมูล

     

     $sql ="insert into bkedit_authority (fid,name,example,descr,ordr,defindi1,defindi2)";

     $sql.=" values ('$fid','$name','$example','$descr','$ordr','$defindi1','$defindi2')";

       //echo $sql;

  if(tmq($sql)) {

  mysql($dbname,$sql2);

  echo"<font face ='ms sans serif'  size ='3'>";

	echo"<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว</b><br></div>";

  echo"<meta http-equiv='refresh' 

content='0;URL=media_type.php?sid=$sid'>";

	echo"</font>";

 

       } else {

      echo"<font face ='ms sans serif'  size ='3'>";

		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";

    	echo"</font>";

	}

	CloseDB();

?>

        <br>

      </td>

    </tr>

  </table>