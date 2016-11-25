<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

if ($removemodule=="yes") {
	tmq("delete from ulibclient where IP='$IPADDR' ");
}
if ($setmodule!="") {
	tmq("delete from ulibclient where IP='$IPADDR' ");
	$descr=addslashes($descr);
	tmq("insert into ulibclient set IP='$IPADDR',
	register='$useradminid',
	descr='$descr',
	registdt='".time()."',
	module='$setmodule'
	");
}

?><BR><?php 
pagesection("กำหนดหน้าหลักของคอมพิวเตอร์เครื่องนี้::l::Set Service for this PC");
$s=tmq("select * from ulibclient where IP='$IPADDR' ");
$r=tmq_fetch_array($s);

	?><TABLE width=780 align=center bgcolor=#E2E2E2>
<FORM METHOD=POST ACTION="setthisclient.php">
	<TR valign=top>
		<TD class=table_head><?php  echo getlang("ไอพีของเครื่องปัจจุบัน::l::Current IP address");?></TD>
		<TD class=table_td><?php  echo $IPADDR?></TD>
	</TR>
	<TR valign=top>
		<TD class=table_head><?php  echo getlang("โน๊ตย่อ::l::Note");?></TD>
		<TD class=table_td><INPUT TYPE="text" NAME="descr" value="<?php  echo $r[descr]?>"></TD>
	</TR>
	<TR valign=top>
		<TD class=table_head><?php  echo getlang("หน้าหลักปัจจุบัน::l::Current Module");?></TD>
		<TD class=table_td><?php  
if ($r[module]=="") {
	echo "-";
} else {
	$mo=tmq("select * from ulibclient_module where code='$r[module]' ");
	$mo=tmq_fetch_array($mo);
	echo getlang( $mo[name] );
}
?></TD>
	</TR>
	<TR valign=top>
		<TD class=table_head><?php  echo getlang("กำหนดหน้าหลัก::l::Set Module");?></TD>
		<TD class=table_td><?php form_quickedit("setmodule",$r[module],"foreign:-localdb-,ulibclient_module,code,name,no,code");?></TD>
	</TR>
	<TR valign=top>
		<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value=" <?php  echo getlang("กำหนด::l::Set");?> "> <?php  echo getlang("หรือ::l::or");?>
		<INPUT TYPE="button" value=" <?php  echo getlang("ไม่ตั้งค่าใด ๆ::l::Remove module");?> " onclick="self.location='setthisclient.php?removemodule=yes' "></TD>
	</TR>
	</FORM>
	</TABLE>
<?php 
foot();
?>