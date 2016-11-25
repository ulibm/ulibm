<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="WebboardOptions";
        mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ตั้งค่าเว็บบอร์ด::l::Webboard Options"));
if ($issave=="yes") {
	viewdiffman_add("webboard-agreement","webboard-agreement",$boardname.$newline.$agreement);

	barcodeval_set("webboard-agreement",addslashes($agreement));
	barcodeval_set("webboard-isenable",addslashes($isenable));
	barcodeval_set("webboard-reviewfirst",addslashes($reviewfirst));
	barcodeval_set("webboard-boardname",addslashes($boardname));
	barcodeval_set("webboard-reqmemid",addslashes($reqmemid));
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50%><?php  echo getlang("ชื่อของเว็บบอร์ด::l::Webboard name");?></td>
  <td width=50%><?php  form_quickedit("boardname",barcodeval_get("webboard-boardname"),"medtext"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable Webboard");?></td>
  <td width=50%><?php  form_quickedit("isenable",barcodeval_get("webboard-isenable"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
  <td width=50%><?php  echo getlang("ข้อตกลงก่อนการโพสท์::l::Post agreement");?></td>
  <td width=50%><?php  form_quickedit("agreement",barcodeval_get("webboard-agreement"),"longtext"); 
    viewdiffman("webboard-agreement","webboard-agreement");

  ?></td>
 </tr>
 <tr valign = "top">
  <td width=50%><?php  echo getlang("ต้องให้เจ้าหน้าที่อนุญาตก่อนจึงจะเห็นข้อความ::l::Librarian must review posts first");?></td>
  <td width=50%><?php  form_quickedit("reviewfirst",barcodeval_get("webboard-reviewfirst"),"yesno"); ?></td>
</tr>
 <tr valign = "top">
  <td width=50%><?php  echo getlang("เฉพาะสมาชิกห้องสมุดโพสท์ได้::l::Only library's member post");?></td>
  <td width=50%><?php  form_quickedit("reqmemid",barcodeval_get("webboard-reqmemid"),"yesno"); ?></td>
</tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
$tmpurl=$dcrURL."webboard/";
html_dialog("","URL = <a target=_blank href='$tmpurl'>$tmpurl</a>");

				foot();
?>