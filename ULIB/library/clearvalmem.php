<?php  //พ
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="miscconfig_memcache";
        mn_lib();
		if ($issave=="yes") {
			tmq("delete from valmem");
			tmq("delete from barcode_valmem");
			html_dialog("Message","Done.");
		}
?>
                <div align = "center">
<?php 
pagesection(getlang("Clear Setting Cache"));

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Start '></td>
</tr></form>
</table>
<?php 
				foot();
?>