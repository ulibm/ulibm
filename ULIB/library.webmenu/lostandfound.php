<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="lostandfound";
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("lostandfound_isenable",addslashes($lostandfound_isenable));
	barcodeval_set("lostandfound_name",addslashes($lostandfound_name));
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
  <td width=50% align=center class=table_td><?php  form_quickedit("lostandfound_name",barcodeval_get("lostandfound_name"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module?");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("lostandfound_isenable",barcodeval_get("lostandfound_isenable"),"yesno"); ?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
</table></form>
<?php 

$tmpurl=$dcrURL."lostandfound/";
html_dialog("","Web URL = <a target=_blank href='$tmpurl'>$tmpurl</a>");


				foot();
?>