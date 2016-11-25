<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu_memfavbook-conf";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("webmenu_memfavbook-o-enable",addslashes($enable));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกระบบหนังสือเล่มโปรด::l::Favourite Book options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("enable",barcodeval_get("webmenu_memfavbook-o-enable"),"yesno"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>