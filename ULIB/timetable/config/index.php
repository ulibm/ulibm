<?php 
	; 
		
        include ("../../inc/config.inc.php");
		head();
		$_REQPERM="rqroom_config";
		mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ตั้งค่าระบบการจองห้อง::l::Request room mudule Options"));
if ($issave=="yes") {
	barcodeval_set("rqroom-onoff",addslashes($onoff));
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50%><?php  echo getlang("เปิดใช้บริการระบบจองห้องหรือไม่::l::Turn on Request room module");?></td>
  <td width=50%><?php  form_quickedit("onoff",barcodeval_get("rqroom-onoff"),"yesno"); ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>