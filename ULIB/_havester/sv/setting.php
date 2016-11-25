<?php 
	; 
        include ("../../inc/config.inc.php");
		head();

        mn_root("havester");
if ($issave=="yes") {
	barcodeval_set("havester-limitnum",addslashes($limitnum));	
	barcodeval_set("havester-tagstocheckdup",addslashes($tagstocheckdup));	
	barcodeval_set("havester-secinterval",addslashes($secinterval));	
	barcodeval_set("havester-limitnumrel",addslashes($limitnumrel));	
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือก::l::Options"));
?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แท็กที่จะใช้ตรวจสอบ::l::Tags, to check duplicates");?></td>
  <td align=center class=table_td><?php  form_quickedit("tagstocheckdup",barcodeval_get("havester-tagstocheckdup"),"longtext"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนที่จะดึงข้อมูลในแต่ละรอบ::l::Number of records to retrieve each round");?></td>
  <td align=center class=table_td><?php  form_quickedit("limitnum",barcodeval_get("havester-limitnum"),"number"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนที่จะดึงข้อมูลในแต่ละรอบ (การตรวจสอบความเชื่อมโยง)::l::Number of records to retrieve each round (Relation check)");?></td>
  <td align=center class=table_td><?php  form_quickedit("limitnumrel",barcodeval_get("havester-limitnumrel"),"number"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนวินาทีที่จะรอในแต่ละรอบ ก่อนดึงข้อมูลใหม่::l::Seconds  of interval to retrieve each round");?></td>
  <td align=center class=table_td><?php  form_quickedit("secinterval",barcodeval_get("havester-secinterval"),"number"); ?> </td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>