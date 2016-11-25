<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="hpsidebar-conf";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("hpsidebar-o-enable",addslashes($enable));
//	barcodeval_set("hpsidebar-o-colo",addslashes($colo));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือก เนื้อหาแถบด้านข้างโฮมเพจ::l::Homepage Side bar options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("enable",barcodeval_get("hpsidebar-o-enable"),"yesno"); ?></td>
 </tr>
<!-- <tr valign = "top">
	<td class=table_head> <?php  echo getlang("สีพื้นหลัง::l::BG color");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("colo",barcodeval_get("hpsidebar-o-colo"),"color"); ?></td>
 </tr> -->

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>