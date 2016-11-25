<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
$_REQPERM="webbox";
mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข URL::l::Edit URL"));
if ($issave=="yes") {
	tmq("delete from webbox_box_rss where refid='$id' ");
	$url=addslashes($url);
	$now=time();
	tmq("insert into webbox_box_rss  set url='$url',refid='$id',maxitem='$maxitem',rsstype='$rsstype',dt=$now,encode='$encset'  ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}
$s=tmq("select * from webbox_box_rss where refid='$id' ");
$s=tmq_fetch_array($s);

?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="locate" value="<?php  echo $locate;?>">

<tr valign = "top">
  <td width=50%><?php  echo getlang("กรุณากรอก URL::l::Enter URL");?></td>
  <td width=50%><?php  form_quickedit("url",$s[url],"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("ประเภทของ Feed::l::Feed type");?></td>
  <td width=50%><?php  form_quickedit("rsstype",$s[rsstype],"list:Text,Text-Topic Only,Photo,Photo With Reflect,Small Photo,Bib and cover style"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("Max Feed items");?></td>
  <td width=50%><?php  form_quickedit("maxitem",$s[maxitem],"number"); ?></td>
 </tr>
  <tr valign = "top">
  <td width=50%><?php  echo getlang("Encode");?></td>
  <td width=50%><?php  form_quickedit("encset",$s[encode],"list:none,tis620,utf8"); ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</tr></form>
</table>
