<?php 

include ("./inc/config.inc.php");
$_REQPERM="quickeditwebtext";
html_start();
mn_lib();
?>
<div align = "center">
<?php 
pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	$now=time();
	$html=addslashes($html);
	$prev=tmq("select * from webpage_quickeditwebtext where classid='$classid' ");
	$prev=tmq_fetch_array($prev);
	$editlog=quickeditwebtext_htmlDiff($prev[html],$html);;
	tmq("delete from webpage_quickeditwebtext where classid='$classid' ");
	tmq("insert into webpage_quickeditwebtext  set html='$html',classid='$classid',lastedit_dt=$now,lastedit_loginid ='$useradminid',editlog='$editlog' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}
$s=tmq("select * from webpage_quickeditwebtext where classid='$classid' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="classid" value="<?php  echo $classid;?>">

 <tr valign = "top">
  <td ><?php  form_quickedit("html",$s[html],"html"); ?><BR>
  <?php 
	frm_globalupload("quickeditwebtext-$classid","html");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>