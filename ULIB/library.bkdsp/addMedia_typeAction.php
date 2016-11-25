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

    // คำสั่งบันทึกลงฐานข้อมูล
     $val=stripslashes($val);
     $val=stripslashes($val);
     $val=addslashes($val);
     $sql ="insert into bkdsp (name,val,ordr,replacewith,hidefid,hidestr,trimthis,linksubf,linkrow,boundwith,formatisn)";
     $sql.=" values ('$name','$val','$ordr','$replacewith','$hidefid','$hidestr','$trimthis','$linksubf','$linkrow','$boundwith','$formatisn')";
       //echo $sql;
  if(tmq($sql)) {
//  mysql($dbname,$sql2);
  echo"<font face ='ms sans serif'  size ='3'>";
	echo"<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว</b><br></div>";
  echo"<meta http-equiv='refresh' content='0;URL=media_type.php?sid=$sid'>";
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