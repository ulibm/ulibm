<?php 
	; 
        include ("../inc/config.inc.php");
$_REQPERM="webbox";
html_start();
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไขข้อความ::l::Edit content"));
if ($issave=="yes") {
	tmq("delete from webbox_pagehtml where classid='$classid' ");
	$html=addslashes($html);
	tmq("insert into webbox_pagehtml  set html='$html',classid='$classid' ");
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
$s=tmq("select * from webbox_pagehtml where classid='$classid' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="classid" value="<?php  echo $classid;?>">

 <tr valign = "top">
  <td ><?php  echo getlang("เนื้อหา::l::Content");?></td>
  <td ><?php  form_quickedit("html",$s[html],"html"); ?><BR>
  <?php 
	frm_globalupload("webbox-pagehtml-$classid","html");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>