<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="webpage-menu";
head();
mn_lib();

pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	tmq("delete from webpage_menu_articledescr where refid='$id' ");
	$title=addslashes($title);
	$body=addslashes($body);
	$now=time();
	tmq("insert into webpage_menu_articledescr  set text='$text',refid='$id' ");
	tmq("update webpage_menu set orderby='$orderby' where id='$id' ");
}
$s=tmq("select * from webpage_menu_articledescr where refid='$id' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td><?php  echo getlang("ชื่อเมนู::l::Menu text");?></td>
  <td width=600><?php  $scatename=tmq("select * from webpage_menu where id='$id' ");
$scatename=tmq_fetch_array($scatename);
echo $scatename[name];
 ?></td>
 </tr> 
 <tr valign = "top">
  <td><?php  echo getlang("บทความในหัวข้อ เรียงตามอะไร::l::Order articles by");?></td>
  <td><?php  form_quickedit("orderby",$scatename[orderby],"list:lastactive,topicname"); ?></td>
 </tr>
 <tr valign = "top">
  <td><?php  echo getlang("คำอธิบายเพิ่ม::l::Description");?></td>
  <td><?php  form_quickedit("text",$s[text],"html"); ?><BR>
    <?php 
	frm_globalupload("webpage_menudescr-$id","text");
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