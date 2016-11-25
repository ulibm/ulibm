<?php 
	; 
        include ("../inc/config.inc.php");
html_start();

?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกอื่น ๆ::l::Options"));
if ($issave=="yes") {
	barcodeval_set("webboxoptions-menupos",$menupos);
	barcodeval_set("webboxoptions-barcolor",$barcolor);
	barcodeval_set("webboxoptions-topmenu_barcolor",$topmenu_barcolor);
	barcodeval_set("webboxoptions-topmenu_barcolorover",$topmenu_barcolorover);
	barcodeval_set("webboxoptions-topmenu_fontsize",$topmenu_fontsize);
	barcodeval_set("webboxoptions-menuwidth",$menuwidth);
	barcodeval_set("webboxoptions-barhtml",$barhtml);
	barcodeval_set("webboxoptions-showminicon",$showminicon);
	barcodeval_set("webboxoptions-fontcolor",$fontcolor);
	barcodeval_set("webboxoptions-columnspace",$columnspace);
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}

?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="locate" value="<?php  echo $locate;?>">
<tr valign = "top">
  <td ><?php  echo getlang("สีพื้นหลังแท็บ::l::Tabs Background Color");?></td>
  <td width=600><?php  form_quickedit("barcolor",barcodeval_get("webboxoptions-barcolor"),"color"); ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("ความกว้างเมนู::l::Menu Width");?></td>
  <td width=600><?php  form_quickedit("menuwidth",barcodeval_get("webboxoptions-menuwidth"),"number"); ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("ตำแหน่งเมนู (ซ้าย-ขวา)::l::Menu Position");?></td>
  <td width=600><?php  form_quickedit("menupos",barcodeval_get("webboxoptions-menupos"),"list:Left,Right"); ?></td>
 </tr>
 <!-- <tr valign = "top">
  <td ><?php  echo getlang("สีตัวอักษรแท็บ::l::Tabs Font Color");?></td>
  <td width=600><?php  form_quickedit("fontcolor",barcodeval_get("webboxoptions-fontcolor"),"color"); ?></td>
 </tr>
 --> <tr valign = "top">
  <td ><?php  echo getlang("เนื้อหาใต้รายการแท็บ::l::HTML under tabs");?></td>
  <td ><?php form_quickedit("barhtml",barcodeval_get("webboxoptions-barhtml"),"html");?><BR>
  <?php 
	frm_globalupload("webboxoptions-barhtml","barhtml");
  ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("แสดงปุ่มย่อขนาดหรือไม่::l::show minimize button");?></td>
  <td width=600><?php  form_quickedit("showminicon",barcodeval_get("webboxoptions-showminicon"),"yesno"); ?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("ระยะห่างระหว่างคอลัมน์::l::Column space");?></td>
  <td width=600><?php  form_quickedit("columnspace",barcodeval_get("webboxoptions-columnspace"),"number"); ?></td>
 </tr>
<tr valign = "top">
  <td colspan=2 align=center class=table_head><?php  echo getlang("ตัวเลือกเมนูด้านบน::l::Options for top menu");?></td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("สีพื้นหลัง::l::Background Color");?></td>
  <td width=600><?php  form_quickedit("topmenu_barcolor",barcodeval_get("webboxoptions-topmenu_barcolor"),"color"); ?> 
  <?php  echo getlang("สีพื้นหลังเมื่อเอาเมาส์วาง::l::Background Color (Mouse Over)");?> <?php  form_quickedit("topmenu_barcolorover",barcodeval_get("webboxoptions-topmenu_barcolorover"),"color"); ?> </td>
 </tr>
<tr valign = "top">
  <td ><?php  echo getlang("ขนาดตัวอักษร::l::Font Size");?></td>
  <td width=600><?php  form_quickedit("topmenu_fontsize",barcodeval_get("webboxoptions-topmenu_fontsize"),"number"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> </td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>