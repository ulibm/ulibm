<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="selfcheckio";
html_start();
mn_lib();
?>
                <div align = "center">
<?php 
if ($issave=="yes") {
	tmq("delete from barcode_valmem;");
	$html=addslashes($html);
	barcodeval_set("selfcheckio-html-$code",$html);
	//die;
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="code" value="<?php  echo $code;?>">
<input type=hidden name="mode" value="<?php  echo $mode;?>">

 <tr valign = "top">
  <td ><?php  echo getlang("เนื้อหา::l::Content");?></td>
  <td ><?php  form_quickedit("html",barcodeval_get("selfcheckio-html-$code"),"$mode"); ?><BR>
  <?php 
  if ($mode=="html") {
	frm_globalupload("selfcheckio-html-$code","html");
 }
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>