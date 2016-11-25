<?php 
	; 
        include ("../../inc/config.inc.php");
$_REQPERM="webmobile_menu";
head();
mn_lib();

pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	tmq("delete from webmobile_menu_content where refid='$id' ");
	$title=addslashes($title);
	$body=addslashes($body);
	$now=time();
	tmq("insert into webmobile_menu_content  set title='$title',body='$body',refid='$id',dt=$now ");
}
$s=tmq("select * from webmobile_menu_content where refid='$id' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
  <td><?php  echo getlang("ชื่อเรื่อง::l::Title");?></td>
  <td width=600><?php  form_quickedit("title",$s[title],"medtext"); ?></td>
 </tr>
 <tr valign = "top">
  <td><?php  echo getlang("เนื้อหา::l::Content");?></td>
  <td><?php  form_quickedit("body",$s[body],"html"); ?><BR>
    <?php 
	frm_globalupload("webmobile_menucontents-$id","body");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="h_menu.php"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>