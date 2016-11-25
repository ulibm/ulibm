<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="memregist-conf";
        mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("ตั้งค่าระบบรับสมัครสมาชิกออนไลน์::l::Online Registration Options"));
if ($issave=="yes") {
  viewdiffman_add("memregist","memregist",$agreement);

	barcodeval_set("memregist-agreement",addslashes($agreement));
	barcodeval_set("memregist-restrictemail",addslashes($restrictemail));
	barcodeval_set("memregist-isactive",addslashes($isactive));
	barcodeval_set("memregist-extfieldname",addslashes($extfieldname));
	barcodeval_set("memregist-defmemregtype",addslashes($defmemregtype));
}
?>
<table border = 0 cellpadding = 0 width = <?php  echo $_TBWIDTH?> align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td ><?php  echo getlang("เปิดใช้งานหรือไม่::l::is use MemberRegist system");?></td>
  <td width=510><?php  form_quickedit("isactive",barcodeval_get("memregist-isactive"),"yesno"); ?></td>
</tr>
 <tr valign = "top">
  <td ><?php  echo getlang("บังคับให้ใส่อีเมล์ และตรวจสอบซ้ำ::l::Must enter email");?></td>
  <td width=510><?php  form_quickedit("restrictemail",barcodeval_get("memregist-restrictemail"),"yesno"); ?></td>
</tr>
 <tr valign = "top">
  <td ><?php  echo getlang("ชื่อฟิลด์เพิ่มเติม::l::Name of description field");?></td>
  <td width=510><?php  form_quickedit("extfieldname",barcodeval_get("memregist-extfieldname"),"text"); ?></td>
</tr>
 <tr valign = "top">
  <td ><?php  echo getlang("ประเภทสมาชิก Default::l::Default member type");?></td>
  <td width=510><?php  form_quickedit("defmemregtype",barcodeval_get("memregist-defmemregtype"),"foreign:-localdb-,member_type,type,descr,no,,allowblank"); ?></td>
</tr>
<tr valign = "top">
  <td ><?php  echo getlang("ข้อตกลงก่อนการสมัคร::l::Agreement");?></td>
  <td ><?php  
  $html_htmlarea_width=680;
  form_quickedit("agreement",barcodeval_get("memregist-agreement"),"html"); 
	viewdiffman("memregist","memregist");
?><BR>
    <?php 
	frm_globalupload("memregist_agreement","agreement");
  ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
	foot();
?>