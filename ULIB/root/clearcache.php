<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("val");
?>
                <div align = "center">
<?php 
pagesection(getlang("เคลียร์แคช ค่าตัวแปร::l::Clear Variables cache"));

if ($clear=="yes") {
	tmq("delete from barcode_valmem");
	tmq("delete from valmem");
	html_dialog("Cache Cleared", "Cache Cleared : " . tra());;
}

?>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="clear" value="yes">
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Start '></td>
</tr>
</table></form>
<?php 
				foot();
?>