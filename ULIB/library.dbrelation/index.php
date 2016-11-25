<?php 
; 
include ("../inc/config.inc.php");
head();
include("_REQPERM.php");
include("conf.php");
mn_lib();
pagesection(getlang("เลือกหัวข้อที่ต้องการตรวจสอบ::l::Select option to check"));
?>
<TABLE width=780 align=center>
<TR valign=top>
	<TD width=300><?php 
@reset($rules);
?><TABLE width=300 align=center><?php 
while (list($k,$v)=each($rules)) {
?>
<TR>
	<TD class=table_head2><A HREF="chk.php?id=<?php  echo $k?>" target=chkframe><?php  echo getlang($v[name]);?></A></TD>
</TR>
<?php 
}?>
</TABLE></TD>
	<TD><iframe width=480 height=500 name=chkframe></iframe></TD>
</TR>
</TABLE>

<?php 
foot();
?>