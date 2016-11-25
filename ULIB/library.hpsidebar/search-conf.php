<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="hpsidebar-searchconf";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("hpsidebarsearch-o-enable",addslashes($enable));
	barcodeval_set("hpsidebarsearch-o-colo",addslashes($colo));
	barcodeval_set("hpsidebarsearch-o-firsthtml",addslashes($firsthtml));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือก เนื้อหาแถบด้านข้างหน้าสืบค้น::l::Searching - Side bar options"));
?>
<table border = 0 cellpadding = 0 width ="<?php  echo $_TBWIDTH?>" align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head width=200> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module");?></td>
  <td  align=center class=table_td><?php  form_quickedit("enable",barcodeval_get("hpsidebarsearch-o-enable"),"yesno"); ?><BR>
  <?php  echo getlang("ตัวเลือกนี้มีผลเฉพาะเมื่อปิดการแสดง USIS ไว้เท่านั้น::l::This option affected only when USIS in set to off.");?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("สีพื้นหลัง::l::BG color");?></td>
  <td  align=center class=table_td><?php  form_quickedit("colo",barcodeval_get("hpsidebarsearch-o-colo"),"color"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด HTML ที่จะแสดงส่วนบนสุด::l::HTML code display at first");?></td>
  <td  align=center class=table_td><?php  form_quickedit("firsthtml",barcodeval_get("hpsidebarsearch-o-firsthtml"),"html"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>