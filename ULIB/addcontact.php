<?php  
;
	include("inc/config.inc.php");
	
?>        <div align = "center">
            <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">

    <tr valign="top"> 
      <td>
<BR>
<table width="550" border="1" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td bgcolor="f2f2f2"><img src="/<?php echo "$dcr";?>/imgpng/BlueSphere.jpg" width="24" height="24" 
align="absmiddle"><font face="MS Sans Serif" size="2"><b><?php echo getlang("ระบบแจ้งว่า::l::System reports"); ?></b></font></td>
  </tr>
  <tr>
    <td>&nbsp;'
 <?php  
		  //ตรวจสอบสิทธิ์ถถ้าไม่ใช่ Root Admin
 ?>
		
		<?php  
		captcha_e();
$now=time();     
     $sql ="insert into contact (topic,body,email,dt)";
     $sql.=" values ('$name','$body','$email',$now)";
  if(tmq($sql)) {
  echo"<font face ='ms sans serif'  size ='3'>";
	echo"<div align=center><br><b>".getlang("ส่งข้อมูลเรียบร้อย::l::Send Complete")."</b><br></div>";
  echo"<meta http-equiv='refresh' content='2;URL=index.php?'>";
	echo"</font>";
       }
 	else {
      echo"<font face ='ms sans serif'  size ='3'>";
		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
    	echo"</font>";
	}
 ?></td>
    </tr>
  </table><BR>
      </td>
    </tr>

  </table>
  
</div>