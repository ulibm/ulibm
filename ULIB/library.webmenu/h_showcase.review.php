<?php 
	; 
   include ("../inc/config.inc.php");
	 $_REQPERM="webpace-suggestbook";
$id=$ID;
if (!library_gotpermission($_REQPERM)) {
	die("require permission $_REQPERM");
}
if ($issave=="yes") {
	tmq("delete from webpage_showcase where mid='$id' ");
	$title=addslashes($title);
	$body=addslashes($body);
	$now=time();
	tmq("insert into webpage_showcase  set title='$title',text='$body',mid='$id',dt=$now, loginid='$useradminid'  ");
	if ($backtome=="indexbib") {
		redir("$dcrURL/dublin.php?ID=$id");
		die;
	}
}
head();
mn_lib();
?>
                <div align = "center">
<?php 

pagesection(getlang("แก้ไขข้อความ Review::l::Edit review"));
?>
<TABLE width=780 align=center>
	<TR>
		<TD><?php res_brief_dsp($id);	
?></TD>
	</TR>
</TABLE><?php 

$s=tmq("select * from webpage_showcase where mid='$id' ");
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
  <td ><?php  echo getlang("เนื้อหา::l::Content");?></td>
  <td ><?php  form_quickedit("body",$s[text],"html"); ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> 
	  <A HREF="h_showcase.php?deletereviewid=<?php  echo $id;?>&backtome=<?php  echo $backtome;?>" class=abtn style="color:darkred" onclick="return confirm('confirm');"><?php  echo getlang("ลบ review นี้::l::Delete this review");?></A> ::
	  <A HREF="<?php 
	if ($backtome=="indexbib") {
		echo("$dcrURL/dublin.php?ID=$id");
	} else {
		echo "h_showcase.php";
	}

	  ?>" class=abtn><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="ID" value="<?php  echo $id;?>">
	  <INPUT TYPE="hidden" NAME="backtome" value="<?php  echo $backtome;?>">
</tr></form>
</table>
<?php 
				foot();
?>