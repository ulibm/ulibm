<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="mocalen-conf";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("mocal-o-dayforward",addslashes($dayforward));
	barcodeval_set("mocal-o-dayhistory",addslashes($dayhistory));
	barcodeval_set("mocal-o-allowcomment",addslashes($allowcomment));
	barcodeval_set("mocal-o-name",addslashes($name));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกระบบปฏิทินกิจกรรม::l::Events calendar options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ชื่อปฏิทิน::l::Calendar name");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("name",barcodeval_get("mocal-o-name"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนวันที่จะแสดงปฏิทินล่วงหน้า::l::Display Forward for _ day");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("dayforward",barcodeval_get("mocal-o-dayforward"),"number"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนวันที่จะแสดงปฏิทินล่วงย้นหลัง::l::Display Backward for _ day");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("dayhistory",barcodeval_get("mocal-o-dayhistory"),"number"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("อนุญาตให้คอมเมนท์ได้หรือไม่::l::Allow comments?");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("allowcomment",barcodeval_get("mocal-o-allowcomment"),"yesno"); ?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>