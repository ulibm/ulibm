<?php 
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="collectionsconf";
	$tmp=mn_lib();
	pagesection($tmp);
?>
                <div align = "center">
<?php 
if ($issave=="yes") {
	barcodeval_set("collections-showlink",addslashes($showlink));
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td width=50%><?php  echo getlang("แสดงลิงค์ที่หน้าหลัก::l::Show Link at homepage");?></td>
  <td width=50%><?php  form_quickedit("showlink",barcodeval_get("collections-showlink"),"yesno"); ?></td>
</tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>