<?php 
include ("../inc/config.inc.php");
if ($permid=="") {
	die("no perm id");
}
$adddir=$dcrs."/_addons/$permid";
if (!is_dir($adddir)) {
	die ("addon [$permid] doesnt exists");
}

if ($reinstall=="yes") {
	@include($dcrs."_addons/$permid/info.php");
	@include($dcrs."_addons/$permid/install.php");
		//install module
	$file=$permid;
	tmq("delete from addons where classid='$file' ");
	tmq("insert into addons set classid='$file',name='".addslashes($addon_name)."' , dtinstall='$now' , installby='$useradminid'  ");
	if ($addon_name=="") {
		$addon_name=getlang("ไม่พบชื่อโมดุล::l::Module name not found")."[$file]";
	}
	$addon_execat=explode(",",$addon_execat);
	$addon_execat=arr_filter_remnull($addon_execat);
	//echo "[$permid]"; printr($addon_execat);
	@reset($addon_execat);
	tmq("delete from  addons_exec where classid='$file' ");
	while (list($k,$v)=each($addon_execat)) {
		tmq("insert into  addons_exec set classid='$file', location='$v' ");
	}
	redir($dcrURL."library/mainadmin.php");
	die;
}
if ($deleteit=="yes") {
	tmq("delete from addons where classid='$permid' ");
	tmq("delete from  addons_exec where classid='$permid' ");
	@rename($dcrs."_addons/$permid",$dcrs."_addons/.$permid"."_delete_".randid());
	redir($dcrURL."library/mainadmin.php");
	die;
}
if ($disabledit=="yes") {
	tmq("update addons set disabled='yes' where classid='$permid' ");
	redir($dcrURL."library/mainadmin.php");
	die;
}
if ($enabledit=="yes") {
	tmq("delete from addons where classid='$permid' ");
	redir($dcrURL."library/mainadmin.php");
	die;
}
head();
	$_REQPERM="manulibaddon";
	mn_lib();
	
	@include("$adddir/info.php");
	$addon_name=getlang("$addon_name");
	pagesection(getlang("จัดการสิทธิ์การใช้สำหรับ::l::Edit permission for").":$addon_name");
?><TABLE align=center width=650>
<TR>
	<TD>
<?php 
	editperm_form("ULIBADDON:$permid");
?><BR>
<?php 
$s=tmq("select * from addons where classid='$permid' ");
$s=tmq_fetch_array($s);
	?><CENTER><?php 
if($s[disabled]=="no") {
	?><FORM METHOD=POST ACTION="permission.php">
		<INPUT TYPE="hidden" NAME="permid" value="<?php  echo $permid?>">
		<INPUT TYPE="hidden" NAME="disabledit" value="yes">
		<INPUT TYPE="submit" value="<?php  echo getlang("คลิกที่นี่เพื่อปิดการใช้งานส่วนเสริมนี้");?>" style="color:red;">
	</FORM><?php 
} else {
	?><FORM METHOD=POST ACTION="permission.php">
		<INPUT TYPE="hidden" NAME="permid" value="<?php  echo $permid?>">
		<INPUT TYPE="hidden" NAME="enabledit" value="yes">
		<INPUT TYPE="submit" value="<?php  echo getlang("คลิกที่นี่เพื่อเปิดการใช้งานส่วนเสริมนี้");?>" style="color:darkgreen;">
	</FORM><?php 
	}
?> 
<FORM METHOD=POST ACTION="permission.php">
		<INPUT TYPE="hidden" NAME="permid" value="<?php  echo $permid?>">
		<INPUT TYPE="hidden" NAME="deleteit" value="yes">
		<INPUT TYPE="submit" value="<?php  echo getlang("ลบ ส่วนเสริมนี้");?>" style="color: red;font-weight: bold;;" onclick="return confirm('delete it?');">
	</FORM>
	<FORM METHOD=POST ACTION="permission.php">
		<INPUT TYPE="hidden" NAME="permid" value="<?php  echo $permid?>">
		<INPUT TYPE="hidden" NAME="reinstall" value="yes">
		<INPUT TYPE="submit" value="<?php  echo getlang("ติดตั้งใหม่");?>" style="color: blue;font-weight: bold;;" onclick="return confirm('Re-install?');">
	</FORM>
	</CENTER></TD>
</TR>
</TABLE>
<B><center><A HREF="../library/mainadmin.php" class=a_btn><?php  echo getlang("กลับ::l::Back")?></A></center></B>
<?php 
foot();
?>