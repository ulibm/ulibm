<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="webbox";
html_start();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข URL::l::Edit URL"));
if ($issave=="yes") {
	tmq("delete from webbox_topmenu_url where refid='$id' ");
	$url=addslashes($url);
	$now=time();
	tmq("insert into webbox_topmenu_url  set url='$url',refid='$id',dt=$now,target='$target' ");
}
$s=tmq("select * from webbox_topmenu_url where refid='$id' ");
$s=tmq_fetch_array($s);
if ($s[target]=="") {
	$s[target]="_top";
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50%><?php  echo getlang("กรุณากรอก URL::l::Enter URL");?></td>
  <td width=50%><?php  form_quickedit("url",$s[url],"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("Target");?></td>
  <td width=50%><?php  form_quickedit("target",$s[target],"text"); ?><BR> _top,_blank,_parent</td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="h_menu.php"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>