<?php 
	; 
        include ("../inc/config.inc.php");
if ($issave=="yes") {
	loginchk_lib();
	  viewdiffman_add("mannualhtmlfooter","mannualhtmlfooter",$mannualhtmlfooter);
	  viewdiffman_add("mannualhtmlheader","mannualhtmlheader",$mannualhtmlheader);
	  viewdiffman_add("mannualhtmlinsideheader","mannualhtmlinsideheader",$mannualhtmlinsideheader);
	  viewdiffman_add("mannualhtmlbeginbody","mannualhtmlbeginbody",$mannualhtmlbeginbody);
	  viewdiffman_add("htmlundertopmenu","htmlundertopmenu",$htmlundertopmenu);
	  viewdiffman_add("pagemetadata","pagemetadata",$pagemetadata);
	  viewdiffman_add("memberloginformhtml","memberloginformhtml",$memberloginformhtml);
	  viewdiffman_add("memberloggedin","memberloggedin",$memberloggedin);

	barcodeval_set("webpage-o-mannualhtmlfooter",addslashes($mannualhtmlfooter));			
	barcodeval_set("webpage-o-mannualhtmlheader",addslashes($mannualhtmlheader));		
	barcodeval_set("webpage-o-mannualhtmlinsideheader",addslashes($mannualhtmlinsideheader));		
	barcodeval_set("webpage-o-mannualhtmlbeginbody",addslashes($mannualhtmlbeginbody));		
	barcodeval_set("webpage-o-htmlundertopmenu",addslashes($htmlundertopmenu));	
	barcodeval_set("webpage-o-pagemetadata",addslashes($pagemetadata));	
	barcodeval_set("webpage-o-memberloginformhtml",addslashes($memberloginformhtml));	
	barcodeval_set("webpage-o-memberloggedin",addslashes($memberloggedin));	
}

		head();
		$_REQPERM="webpage-optionshtml";
        mn_lib();

?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกของหน้าโฮมเพจ::l::Homepage options"));
?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด HTML ที่ส่วนหัวของทุกเพจ ::l::HTML Code at page footer");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mannualhtmlheader",barcodeval_get("webpage-o-mannualhtmlheader"),"html"); 
  viewdiffman("mannualhtmlheader","mannualhtmlheader");
?></td>
 </tr>
<tr valign = "top">
	<td class=table_head></td>
  <td align=center class=table_td width=600><?php 
	frm_globalupload("websetting-mannualhtmlheader","mannualhtmlheader");
  ?></td>
 </tr>


  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด HTML ที่ด้านล่างของทุกเพจ ::l::HTML Code at page footer");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mannualhtmlfooter",barcodeval_get("webpage-o-mannualhtmlfooter"),"html");
    viewdiffman("mannualhtmlfooter","mannualhtmlfooter");
?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head></td>
  <td align=center class=table_td><?php 
	frm_globalupload("websetting-mannualhtmlfooter","mannualhtmlfooter");
  ?></td>
 </tr>


  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด HTML ที่แทรกในส่วนหัว ::l::HTML Code inside page header");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mannualhtmlinsideheader",barcodeval_get("webpage-o-mannualhtmlinsideheader"),"verylongtext");
viewdiffman("mannualhtmlinsideheader","mannualhtmlinsideheader");
?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด META-DATA ::l::HTML META");?></td>
  <td  align=center class=table_td><?php  form_quickedit("pagemetadata",barcodeval_get("webpage-o-pagemetadata"),"verylongtext");
viewdiffman("pagemetadata","pagemetadata");
?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("โค้ด HTML ที่ส่วนแรกของเพจ (หลังแท็ก &lt;body&gt; ::l::HTML Code at beginning of page (after &lt;body&gt; tag)");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mannualhtmlbeginbody",barcodeval_get("webpage-o-mannualhtmlbeginbody"),"verylongtext");
  viewdiffman("mannualhtmlbeginbody","mannualhtmlbeginbody");

?></td>
 </tr>


  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อความใต้เมนูส่วนหัว::l::Text under top menu");?></td>
  <td align=center class=table_td><?php  form_quickedit("htmlundertopmenu",barcodeval_get("webpage-o-htmlundertopmenu"),"html"); 
   viewdiffman("htmlundertopmenu","htmlundertopmenu");
 ?> </td>
 </tr>
<tr valign = "top">
	<td class=table_head></td>
  <td align=center class=table_td><?php 
	frm_globalupload("htmlundertopmenu","htmlundertopmenu");
  ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("HTML หน้าแบบฟอร์มล็อกอินของสมาชิก::l::HTML at member's login form");?></td>
  <td  align=center class=table_td><?php  form_quickedit("memberloginformhtml",barcodeval_get("webpage-o-memberloginformhtml"),"html"); 
     viewdiffman("memberloginformhtml","memberloginformhtml");

?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("HTML หน้าเมนูสมาชิก (เมื่อล็อกอินแล้ว)::l::HTML at member's main page");?></td>
  <td  align=center class=table_td><?php  form_quickedit("memberloggedin",barcodeval_get("webpage-o-memberloggedin"),"html"); 
     viewdiffman("memberloggedin","memberloggedin");

?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>