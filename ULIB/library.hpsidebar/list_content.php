<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="hpsidebar-content";
if ($locate=="homepage") {
	$_REQPERM= "hpsidebar-content";
}
if ($locate=="search") {
	$_REQPERM= "hpsidebar-search";
}
if ($locate=="left") {
	$_REQPERM= "hpsidebar-leftcontent";
}

head();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	tmq("delete from webpage_hpsidebar_content where refid='$id' ");
	$title=addslashes($title);
	$body=addslashes($body);
	$now=time();
	tmq("insert into webpage_hpsidebar_content  set title='$title',body='$body',refid='$id',dt=$now ");
}
$s=tmq("select * from webpage_hpsidebar_content where refid='$id' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="locate" value="<?php  echo $locate;?>">
<tr valign = "top">
  <td ><?php  echo getlang("ชื่อเรื่อง::l::Title");?></td>
  <td width=600><?php  form_quickedit("title",$s[title],"medtext"); ?></td>
 </tr>
 <tr valign = "top">
  <td ><?php  echo getlang("เนื้อหา::l::Content");?></td>
  <td ><?php  form_quickedit("body",$s[body],"html"); ?><BR>
  <?php 
	frm_globalupload("allhpsidebar-$locate","body");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="<?php 
if ($locate=="homepage") {
	echo "list.php";
}
if ($locate=="search") {
	echo "list-search.php";
}
if ($locate=="left") {
	echo "list-left.php";
}

	  ?>"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
<?php 
				foot();
?>