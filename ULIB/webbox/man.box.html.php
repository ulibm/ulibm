<?php 
	; 
        include ("../inc/config.inc.php");
html_start();
	 $_REQPERM="webbox";
	 mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	tmq("delete from webbox_box_content where refid='$id' ");
	$title=addslashes($title);
	$body=addslashes($body);
	$now=time();
	tmq("insert into webbox_box_content  set title='$title',body='$body',refid='$id',dt=$now ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
   if(self==top){
      top.location = "<?php echo $dcrURL;?>";
   } else {
      top.location.reload();
   }	//-->
	</SCRIPT><?php 
	die;
}
$s=tmq("select * from webbox_box_content where refid='$id' ");
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
	frm_globalupload("webbox-html-$id","body");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> </td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>