<?php 
	; 
        include ("../inc/config.inc.php");
head();
$_REQPERM="acqxls_settingpage";
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกอื่น ๆ::l::Options"));
if ($issave=="yes") {
	barcodeval_set("acqxls-excelheader",$excelheader);
	barcodeval_set("acqxls-suggestionform_head",$suggestionform_head);
	barcodeval_set("acqxls-suggestionform_body",$suggestionform_body);
	barcodeval_set("acqxls-suggestionform_memstatus",$suggestionform_memstatus);
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		//top.location.reload();
	//-->
	</SCRIPT><?php 
	redir($PHP_SELF);
	die;
}

?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="locate" value="<?php  echo $locate;?>">
<tr valign = "top">
  <td ><?php  echo getlang("ส่วนหัวแบบฟอร์มรายงาน Excel::l::Excel Header");?></td>
  <td width=600><?php  form_quickedit("excelheader",barcodeval_get("acqxls-excelheader"),"longtext"); ?></td>
 </tr>

<tr valign = "top">
  <td ><?php  echo getlang("ข้อความหน้าแนะนำสั่งซื้อ ส่วนหัว::l::Header text in suggestion form");?></td>
  <td width=600><?php  form_quickedit("suggestionform_head",barcodeval_get("acqxls-suggestionform_head"),"text"); ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("ข้อความหน้าแนะนำสั่งซื้อ::l::text in suggestion form");?></td>
  <td width=600><?php  form_quickedit("suggestionform_body",barcodeval_get("acqxls-suggestionform_body"),"longtext"); ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("สถานะของผู้สั่งซื้อ::l::Status of suggestor");?></td>
  <td width=600><?php  form_quickedit("suggestionform_memstatus",barcodeval_get("acqxls-suggestionform_memstatus"),"longtext"); ?>
  <br><font class=smaller><?php  echo getlang("1 บรรทัดต่อ 1 รายการ::l::1 line per 1 status") ;?></font></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> </td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
foot();
?>