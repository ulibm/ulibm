<?php 
	; 
        include ("../inc/config.inc.php");
        include ("./_REQPERM.php");
        include ("./cfg.inc.php");
		head();
        mn_lib();
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
		<TD align=right>
		<?php 
	pagesection(getlang("การตั้งค่า::l::Settings"),"article");
if ($issave=="yes") {
	barcodeval_set("webpage-indexphotonews_isenable",addslashes($indexphotonews_isenable));
	barcodeval_set("webpage-indexphotonews_setheight",addslashes($indexphotonews_setheight));
	barcodeval_set("webpage-indexphotonews_style",addslashes($indexphotonews_style));
	echo "<CENTER><FONT style=\"color:darkred;font-size:17\">".getlang("บันทึกข้อมูลเรียบร้อย::l::Setting Saved")."</FONT></CENTER>";
}
			?>
<BR>
<table border = 0 cellpadding = 0 width = 100% align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module");?></td>
  <td  align=center class=table_td><?php  form_quickedit("indexphotonews_isenable",barcodeval_get("webpage-indexphotonews_isenable"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("รูปแบบการแสดงผล::l::Display style");?></td>
  <td  align=center class=table_td><?php  form_quickedit("indexphotonews_style",barcodeval_get("webpage-indexphotonews_style"),"list:Frame,Matrix,Frame With Caption"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ความสูงภาพ::l::Display Height");?></td>
  <td  align=center class=table_td><?php  form_quickedit("indexphotonews_setheight",barcodeval_get("webpage-indexphotonews_setheight"),"number"); ?>
  <?php  echo getlang("ค่าปกติคือ 270::l::Default is 270");?></td>
 </tr>

 

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>

		</TD>

</TR>
</TABLE><BR><BR>
<?php 
				foot();
?>