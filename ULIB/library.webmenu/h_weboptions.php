<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu-weboptions";
        mn_lib();
if ($issave=="yes") {

	barcodeval_set("webpage-o-isshowquicksearch",addslashes($isshowquicksearch));
	barcodeval_set("webpage-o-isshowcalendar",addslashes($isshowcalendar));

	barcodeval_set("webpage-o-isshowcalendarleftmenu",addslashes($isshowcalendarleftmenu));	
	barcodeval_set("webpage-o-isshowothermenugroup",addslashes($isshowothermenugroup));	
	barcodeval_set("webpage-o-isshowboardcategroup",addslashes($isshowboardcategroup));		
	barcodeval_set("webpage-o-isshowcalendarleftmenu",addslashes($isshowcalendarleftmenu));	
	barcodeval_set("webpage-o-ishidetopmenuathomepage",addslashes($ishidetopmenuathomepage));	
	barcodeval_set("webpage-o-webpage_isshowwebjump",addslashes($webpage_isshowwebjump));	

	barcodeval_set("webpage-o-ishide_menuadvsear",addslashes($ishide_menuadvsear));	
	barcodeval_set("webpage-o-ishide_menubasicsear",addslashes($ishide_menubasicsear));	
	barcodeval_set("webpage-o-ishide_menumemlogin",addslashes($ishide_menumemlogin));	
	//barcodeval_set("webpage-o-htmlunderleftmenu",addslashes($htmlunderleftmenu));	
	//barcodeval_set("webpage-o-htmlundertopmenu",addslashes($htmlundertopmenu));	
	if ($_ISULIBMASTER=="yes") {
		barcodeval_set("webpage-o-ishide_menuusissearch",addslashes($ishide_menuusissearch));	
	}

}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกของหน้าโฮมเพจ::l::Homepage options"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

  <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("ตัวเลือกของหน้าจอแบบโฮมเพจ::l::Homepage's Options");?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงปฏิทินเล็กหรือไม่::l::Display Calendar?");?></td>
  <td width=480 align=center class=table_td><?php  form_quickedit("isshowcalendar",barcodeval_get("webpage-o-isshowcalendar"),"yesno"); ?></td>
 </tr>
 <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงปฏิทินเล็กใต้เมนูด้านซ้าย::l::Display Calendar under menu");?></td>
  <td align=center class=table_td><?php  form_quickedit("isshowcalendarleftmenu",barcodeval_get("webpage-o-isshowcalendarleftmenu"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงช่องสืบค้นข้อมูลด่วนหรือไม่::l::Display Quick Search?");?></td>
  <td align=center class=table_td><?php  form_quickedit("isshowquicksearch",barcodeval_get("webpage-o-isshowquicksearch"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงเมนู หัวข้อเว็บบอร์ด ที่เมนูซ้าย::l::Display 'Webboard Category' group?");?></td>
  <td align=center class=table_td><?php  form_quickedit("isshowboardcategroup",barcodeval_get("webpage-o-isshowboardcategroup"),"yesno"); ?></td>
 </tr> 
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงเมนู อื่น ๆ ที่เมนูซ้าย::l::Display 'Other menues' group?");?></td>
  <td align=center class=table_td><?php  form_quickedit("isshowothermenugroup",barcodeval_get("webpage-o-isshowothermenugroup"),"yesno"); ?></td>
 </tr>
   <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนูหลักเว็บไซต์ด้านบน ที่โฮมเพจ::l::Hide top menu at Homepage?");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishidetopmenuathomepage",barcodeval_get("webpage-o-ishidetopmenuathomepage"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดง Dropdown ลิงค์ด่วนที่ท้ายเพจ::l::Show Dropdown Quick menu");?></td>
  <td  align=center class=table_td><?php  form_quickedit("webpage_isshowwebjump",barcodeval_get("webpage-o-webpage_isshowwebjump"),"yesno"); ?></td>
 </tr>

  <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("เมนูหลัก::l::Mainmenu's Options");?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนู Advance Search::l::Hide 'Advance Search'");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishide_menuadvsear",barcodeval_get("webpage-o-ishide_menuadvsear"),"yesno"); ?></td>
 </tr>

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนู Basic Search::l::Hide 'Basic Search'");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishide_menubasicsear",barcodeval_get("webpage-o-ishide_menubasicsear"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนู สมาชิกล็อกอิน::l::Hide 'Member Login'");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishide_menumemlogin",barcodeval_get("webpage-o-ishide_menumemlogin"),"yesno"); ?></td>
 </tr>
 <?php 
 	if ($_ISULIBMASTER=="yes") {
 ?>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนเมนู USIS Search::l::Hide 'USIS Search'");?></td>
  <td align=center class=table_td><?php  form_quickedit("ishide_menuusissearch",barcodeval_get("webpage-o-ishide_menuusissearch"),"yesno"); ?></td>
 </tr>
<?php 
  }
?>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>