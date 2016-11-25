<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="webpage-menu";
head();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข URL::l::Edit URL"));
if ($issave=="yes") {
	barcodeval_set("WEB-MENU-SEPPERCOLOR-$id",$colssepper);
}
$s=barcodeval_get("WEB-MENU-SEPPERCOLOR-$id");

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50%><?php  echo getlang("กรุณาเลือกสี::l::Select Color");?></td>
  <td width=50%><?php  form_quickedit("colssepper",$s,"color"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="h_menu.php"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>