<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu_bibtag-conf";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("bibtag-o-enable",addslashes($enable));
	barcodeval_set("bibtag-o-autogrant",addslashes($autogrant));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกระบบระบบให้แท็ก Bib::l::Add Bib. tag options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("enable",barcodeval_get("bibtag-o-enable"),"yesno"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("รับคำใหม่อัตโนมัติ::l::Auto accept new tagname");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("autogrant",barcodeval_get("bibtag-o-autogrant"),"yesno"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>