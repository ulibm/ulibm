<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu-hphtml";
        mn_lib();
if ($issave=="yes") {
  viewdiffman_add("hphtml_htmlunderleftmenu","hphtml_htmlunderleftmenu",$htmlunderleftmenu);
  viewdiffman_add("hphtml_htmltoallwikis","hphtml_htmltoallwikis",$htmltoallwikis);

	barcodeval_set("webpage-o-htmlunderleftmenu",addslashes($htmlunderleftmenu));	
	barcodeval_set("webpage-o-htmltoallwikis",addslashes($htmltoallwikis));	
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
	<td class=table_head> <?php  echo getlang("ข้อความใต้เมนูด้านซ้าย::l::Text under left menu");?></td>
  <td align=center class=table_td><?php  form_quickedit("htmlunderleftmenu",barcodeval_get("webpage-o-htmlunderleftmenu"),"html");
    viewdiffman("hphtml_htmlunderleftmenu","hphtml_htmlunderleftmenu");

  ?> </td>
 </tr>
<tr valign = "top">
	<td class=table_head></td>
  <td align=center class=table_td><?php 
	frm_globalupload("htmlunderleftmenu","htmlunderleftmenu");
  ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อความที่จะแนบกับบทความ Wiki ทุกบทความ::l::Text to attatch all wiki article");?></td>
  <td align=center class=table_td><?php  form_quickedit("htmltoallwikis",barcodeval_get("webpage-o-htmltoallwikis"),"html");
      viewdiffman("hphtml_htmltoallwikis","hphtml_htmltoallwikis");
?> </td>
 </tr>
<tr valign = "top">
	<td class=table_head></td>
  <td align=center class=table_td><?php 
	frm_globalupload("htmltoallwikis","htmltoallwikis");
  ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>