<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webpage-Homepagegreeting";
        mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ข้อความต้อนรับที่หน้าแรก::l::Homepage greeting"));
if ($issave=="yes") {
  viewdiffman_add("Homepagegreeting","Homepagegreeting",$Homepagegreetingline.$newline.$Homepagegreeting);
	barcodeval_set("webpage-Homepagegreeting",addslashes($Homepagegreeting));
	barcodeval_set("webpage-Homepagegreetingline",addslashes($Homepagegreetingline));
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50% align=center><?php echo getlang("บรรทัดแสดงข้อความต้อนรับ::l::Greeting line");?><BR>
  <?php  form_quickedit("Homepagegreetingline",barcodeval_get("webpage-Homepagegreetingline"),"text"); ?></td>
 </tr>
 
 <tr valign = "top">
  <td width=50% align=center><?php  form_quickedit("Homepagegreeting",barcodeval_get("webpage-Homepagegreeting"),"html"); 
  viewdiffman("Homepagegreeting","Homepagegreeting");
  ?><BR>
    <?php 
	frm_globalupload("Homepagegreeting","Homepagegreeting");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>