<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไขตัวแบ่ง::l::Edit Divider"));
if ($issave=="yes") {
	tmq("delete from webbox_sepper where pid='$id' ");
	$str=addslashes($str);
	$descr=addslashes($descr);
	$now=time();
	tmq("insert into webbox_sepper  set str='$str',pid='$id',descr='$descr',type1='$type1',col='$col',col2='$col2' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}
$s=tmq("select * from webbox_sepper where pid='$id' ");
$s=tmq_fetch_array($s);

?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=10>

<tr valign = "top">
  <td width=50%><?php  echo getlang("ข้อความ::l::Divider text");?></td>
  <td width=50%><?php  form_quickedit("str",$s[str],"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("ข้อความเพิ่มเติม::l::Description text");?></td>
  <td width=50%><?php  form_quickedit("descr",$s[descr],"longtext"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("รูปแบบของตัวแบ่ง::l::Divider type");?></td>
  <td width=50%><?php  form_quickedit("type1",$s[type1],"foreign:-localdb-,webbox_sepper_type,code,name"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("สีตัวอักษร::l::Font Color");?></td>
  <td width=50%><?php  form_quickedit("col",$s[col],"color"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50%><?php  echo getlang("สีประกอบ::l::Effect Color");?></td>
  <td width=50%><?php  form_quickedit("col2",$s[col2],"color"); ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
	
</tr>
</table>  <INPUT TYPE="hidden" NAME="id" value="<?php  echo $id;?>">
</form>
<center>
<a href='man.sepperman.php' class='a_btn smaller2'><?php  echo getlang("แก้ไขรูปแบบตัวแบ่ง::l::Edit seperator styles");?></a>
</center>