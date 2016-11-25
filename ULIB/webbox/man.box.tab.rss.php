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
	tmq("delete from webbox_boxtab_rss where refid='$id' ");
	$url=addslashes($url);
	$now=time();
	tmq("insert into webbox_boxtab_rss  set url='$url',refid='$id',maxitem='$maxitem',rsstype='$rsstype',dt=$now,encode='$encset' ");
	redir("man.box.tab.php?pid=$pid");
	die;
}
$s=tmq("select * from webbox_boxtab_rss where refid='$id' ");
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
  <td width=50%><?php  form_quickedit("rsstype",$s[rsstype],"list:Text,Photo,Photo With Reflect,Small Photo,Bib and cover style,Text-Topic Only"); ?></td>
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
	  <td colspan=2 align=center><input type=submit value=' Submit '> <A HREF="list_tab.php?locate=<?php  echo $locate?>&pid=<?php  echo $pid?>"><?php  echo getlang("กลับ::l::Back");?></A></td>
	  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
	  <INPUT TYPE="hidden" NAME="pid" value="<?php  echo $pid;?>">
</tr></form>
</table>
<?php 
				foot();
?>