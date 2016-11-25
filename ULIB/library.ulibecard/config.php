<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="ulibecard-config";
      $tmp=mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang($tmp));
if ($issave=="yes") {
   viewdiffman_add("ulibecard-agreement","ulibecard-agreement",$systemname.$newline.$agreement);
   
	barcodeval_set("ulibecard-agreement",addslashes($agreement));
	barcodeval_set("ulibecard-isenable",addslashes($isenable));
	barcodeval_set("ulibecard-systemname",addslashes($systemname));
}
?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=30>
<tr valign = "top">
<tr valign = "top">
  <td width=50%><?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable ulibecard");?></td>
  <td width=50%><?php  form_quickedit("isenable",barcodeval_get("ulibecard-isenable"),"yesno"); ?></td>
 </tr>
  <td width=50%><?php  echo getlang("ข้อความชื่อระบบ::l::System name name");?></td>
  <td width=50%><?php  form_quickedit("systemname",barcodeval_get("ulibecard-systemname"),"medtext"); ?></td>
 </tr>
 <tr valign = "top">
  <td width=50%><?php  echo getlang("ข้อตกลงการใช้งาน::l::Agreement");?></td>
  <td width=50%><?php  form_quickedit("agreement",barcodeval_get("ulibecard-agreement"),"html"); 
    viewdiffman("ulibecard-agreement","ulibecard-agreement");
  ?></td>
 </tr>
  <tr valign = "top">
	<td ></td>
  <td align=center class=table_td><?php 
	frm_globalupload("ulibecard-agreementft","ulibecard-agreement");
  ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
</table></form>
<?php 


				foot();
?>