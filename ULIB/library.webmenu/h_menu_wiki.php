<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="webpage-menu";
head();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข URL::l::Edit URL"));
if ($issave=="yes") {
	tmq("delete from webpage_menu_wiki where refid='$id' ");
	$url=addslashes($url);
	$now=time();
	tmq("insert into webpage_menu_wiki  set text='$text',refid='$id',dt=$now ");
}
$s=tmq("select * from webpage_menu_wiki where refid='$id' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td width=50%><?php  echo getlang("กรุณากรอก URL::l::Enter URL");?></td>
  <td width=50%><?php  form_quickedit("text",$s[text],"text"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="h_menu.php"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>