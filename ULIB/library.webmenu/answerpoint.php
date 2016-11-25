<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="answerpoint";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("answerpoint_isenable",addslashes($answerpoint_isenable));
	barcodeval_set("answerpoint_name",addslashes($answerpoint_name));
	barcodeval_set("answerpoint_agreement",addslashes($answerpoint_agreement));
	barcodeval_set("answerpoint_respemail",addslashes($answerpoint_respemail));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือก::l::Options"));
?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">


<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ชื่อระบบ::l::System name");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("answerpoint_name",barcodeval_get("answerpoint_name"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module?");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("answerpoint_isenable",barcodeval_get("answerpoint_isenable"),"yesno"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อความเงื่อนไขก่อนการโพสท์คำถาม::l::Agreement befor post");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("answerpoint_agreement",barcodeval_get("answerpoint_agreement"),"longtext"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("อีเมล์ผู้รับผิดชอบ::l::Notification to email");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("answerpoint_respemail",barcodeval_get("answerpoint_respemail"),"text"); ?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
</table></form>
<?php 
$tmpurl=$dcrURL."answerpoint/";
html_dialog("","Web URL = <a target=_blank href='$tmpurl'>$tmpurl</a>");

				foot();
?>