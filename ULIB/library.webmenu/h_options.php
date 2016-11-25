<?php 
	; 
        include ("../inc/config.inc.php");
if ($issave=="yes") {
	$_HTMLTEMPLATE=$htmltemplate;
}
		head();
		$_REQPERM="webpage-options";
        mn_lib();
if ($issave=="yes") {
   tmq("delete from barcode_valmem");
	barcodeval_set("display_dublinrelatebib",addslashes($display_dublinrelatebib));
	barcodeval_set("webpage-o-flattabcol",addslashes($flattabcol));
	barcodeval_set("webpage-o-upacnopopup",addslashes($upacnopopup));
	barcodeval_set("webpage-o-upachideitem",addslashes($upachideitem));
	barcodeval_set("webpage-o-upachideaddlink2",addslashes($upachideaddlink2));
	barcodeval_set("webpage-o-upachideaddlink",addslashes($upachideaddlink));
	barcodeval_set("webpage-o-upachidechkperinfo",addslashes($upachidechkperinfo));

	barcodeval_set("webpage-o-htmltemplate",addslashes($htmltemplate));
	barcodeval_set("webpage-o-resultperpage",addslashes($resultperpage));

	barcodeval_set("webpage-o-searchmdlangdecis",addslashes($searchmdlangdecis));
	barcodeval_set("webpage-o-searchmdtypedecis",addslashes($searchmdtypedecis));
	barcodeval_set("webpage-o-searchmdplacedecis",addslashes($searchmdplacedecis));
	barcodeval_set("webpage-o-searchmdyeadecis",addslashes($searchmdyeadecis));
	
	barcodeval_set("webpage-o-memberloginthengoto",addslashes($memberloginthengoto));		
	barcodeval_set("webpage-o-searchautocallnfiltertype",addslashes($searchautocallnfiltertype));
	barcodeval_set("webpage-o-viewbib_showsocialacc",addslashes($viewbib_showsocialacc));
	barcodeval_set("webpage-o-viewbib_emailtome",addslashes($viewbib_emailtome));

	barcodeval_set("webpage-o-canmemberloginbyemail",addslashes($canmemberloginbyemail));
	barcodeval_set("webpage-o-ishidetopmenuathomepage",addslashes($ishidetopmenuathomepage));
	barcodeval_set("webpage-o-mem_forgotpwdoption",addslashes($mem_forgotpwdoption));
	barcodeval_set("webpage-o-mem_menustyle",addslashes($mem_menustyle));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกของหน้าโฮมเพจ::l::Homepage options"));
?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("ตัวเลือกสมาชิก ::l::Member options");?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("เมื่อสมาชิกล็อกอินแล้ว ไปที่::l::When member login, goto");?></td>
  <td  align=center class=table_td><?php  form_quickedit("memberloginthengoto",barcodeval_get("webpage-o-memberloginthengoto"),"list:Member_Page,Homepage"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("อนุญาตให้สมาชิกล็อกอินด้วยอีเมล์::l::allow member to login by email");?></td>
  <td  align=center class=table_td><?php  form_quickedit("canmemberloginbyemail",barcodeval_get("webpage-o-canmemberloginbyemail"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("เตือนลืมรหัสผ่านทางอีเมล์::l::Send Forgotten password by email");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mem_forgotpwdoption",barcodeval_get("webpage-o-mem_forgotpwdoption"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("รูปแบบเมนูหน้าสมาชิก::l::Member's menu style");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mem_menustyle",barcodeval_get("webpage-o-mem_menustyle"),"list:Classic,Flat tab"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("สีพื้นหลังของ Flat Tab::l::Flat tab background color");?></td>
  <td  align=center class=table_td><?php  form_quickedit("flattabcol",barcodeval_get("webpage-o-flattabcol"),"longtext"); ?></td>
 </tr>

 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("ตัวเลือกการปรับแต่ง UPAC::l::Display UPAC Option");?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนผลการสืบค้นต่อ 1 หน้า::l::Result per 1 page");?></td>
  <td  align=center class=table_td><?php  form_quickedit("resultperpage",barcodeval_get("webpage-o-resultperpage"),"number"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ใช้หน้าต่างเดิมเมื่อคลิกดูรายละเอียด ::l::Do not popup new window on click?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("upacnopopup",barcodeval_get("webpage-o-upacnopopup"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงรายการใกล้เคียงที่หน้าแสดงผล ::l::Show relate Bib at UPAC");?></td>
  <td  align=center class=table_td><?php  form_quickedit("display_dublinrelatebib",barcodeval_get("display_dublinrelatebib"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนไอเทมของวัสดุ ::l::Hide Media's items?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("upachideitem",barcodeval_get("webpage-o-upachideitem"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนปุ่มตรวจสอบรายละเอียดส่วนตัวของสมาชิก ::l::Hide Check member's info Btn?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("upachidechkperinfo",barcodeval_get("webpage-o-upachidechkperinfo"),"yesno"); ?></td>
 </tr>
   <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนูหลักเว็บไซต์ด้านบน ที่โฮมเพจ::l::Hide top menu at Homepage?");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishidetopmenuathomepage",barcodeval_get("webpage-o-ishidetopmenuathomepage"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนลิงค์เพิ่มเติมที่แบบฟอร์มสืบค้น ::l::Hide Additional link on search form?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("upachideaddlink",barcodeval_get("webpage-o-upachideaddlink"),"yesno"); ?><BR><FONT class=smaller2><?php 
  echo getlang("วันปิดทำการ::l::Close Service").",";
  echo getlang("ประเภทวัสดุสารสนเทศ::l::Resource Type").",";
  echo getlang("หัวเรื่อง::l::Subjects")
  ?></FONT></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนลิงค์เพิ่มเติม (2) ที่แบบฟอร์มสืบค้น ::l::Hide Additional link (2) on search form?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("upachideaddlink2",barcodeval_get("webpage-o-upachideaddlink2"),"yesno"); ?><BR><FONT class=smaller2><?php 
  echo getlang("ติดต่อเจ้าหน้าที่::l::Contact librarian").",";
  echo getlang("ฐานข้อมูลใช้ฟรี::l::Free Database");
  ?></FONT></td>
 </tr>



 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แสดงตัวเลือกกำหนดการสืบค้น ::l::Display Search Refining");?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ประเภทวัสดุ ::l::Media type?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("searchmdtypedecis",barcodeval_get("webpage-o-searchmdtypedecis"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang(" สถานที่จัดเก็บ ::l::Media Shelves?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("searchmdplacedecis",barcodeval_get("webpage-o-searchmdplacedecis"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ภาษา ::l::Media Language?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("searchmdlangdecis",barcodeval_get("webpage-o-searchmdlangdecis"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ปีพิมพ์ ::l::Publish Year?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("searchmdyeadecis",barcodeval_get("webpage-o-searchmdyeadecis"),"yesno"); ?></td>
 </tr>
 
 
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แสดงตัวเลือกกำหนดการสืบค้น ::l::Display Search Refining");?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แนะนำเลขหมู่อัตโนมัติแบบใด ::l::Auto suggest callnumber type");?></td>
  <td  align=center class=table_td><?php  form_quickedit("searchautocallnfiltertype",barcodeval_get("webpage-o-searchautocallnfiltertype"),"list:DC,LC/NLM,Not show"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงตัวเลือกเพิ่มเติมสำหรับ Social Internet ::l::Display Social Internet accessories?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("viewbib_showsocialacc",barcodeval_get("webpage-o-viewbib_showsocialacc"),"yesno"); ?></td>
 </tr>

 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงปุ่ม อีเมล์รายการนี้::l::Show button Email this record?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("viewbib_emailtome",barcodeval_get("webpage-o-viewbib_emailtome"),"yesno"); ?></td>
 </tr>





	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>