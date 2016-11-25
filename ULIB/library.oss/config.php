<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="oss-conf";
        $tmp=mn_lib();
		tmq("delete from barcode_valmem");
if ($issave=="yes") {
	barcodeval_set("oss-o-isopen",addslashes($isopen));
	barcodeval_set("oss-o-name",addslashes($name));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("$tmp"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่ ::l::Open This Module");?></td>
  <td  align=center class=table_td><?php  form_quickedit("isopen",barcodeval_get("oss-o-isopen"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ชื่อฟังก์ชัน ::l::Functionname");?></td>
  <td  align=center class=table_td><?php  form_quickedit("name",barcodeval_get("oss-o-name"),"text"); ?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></td>
</tr></form>
</table>
<?php 
				foot();
?>