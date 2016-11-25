<?php 
	; 
        include ("../../inc/config.inc.php");
$_REQPERM="webmobile_menu";
head();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข URL::l::Edit URL"));
if ($issave=="yes") {
	barcodeval_set("WEBMOBILE-MENU-SEPPERCOLOR-$id",$colssepper);
}
$s=barcodeval_get("WEBMOBILE-MENU-SEPPERCOLOR-$id");

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td colspan=2 align=center><img src=theme.png></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("กรุณาเลือกสี::l::Select Color");?></td>
  <td width=50%><?php  form_quickedit("colssepper",$s,"list:a,b,c,d,e"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="h_menu.php"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>