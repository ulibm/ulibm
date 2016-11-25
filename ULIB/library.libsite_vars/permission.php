<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="libsite_vars";
$tmp=mn_lib();
if ($act=="add") {
	tmq("insert into libsite_permission set libfrom='$libsite' , libto='$libto',code='$code'  ");
}
if ($act=="close") {
	tmq("delete from libsite_permission where libfrom='$libsite' and libto='$libto' and code='$code'  ");
}
$s=tmq("select * from library_site where code='$libsite' ");
$s=tmq_fetch_array($s);
?>
<BR>
<TABLE width=780 align=center class=table_border>
<TR>
	<TD width=100><B><?php  echo getlang("โค้ด::l::Code"); ?></B></TD>
	<TD><?php  echo $s[code]?></TD>
</TR>
<TR>

	<TD width=100><B><?php  echo getlang("ชื่อสาขา::l::Name"); ?></B></TD>
	<TD><?php  echo $s[name]?></TD>
</TR>
</TABLE>
<CENTER><BR><B><?php  echo getlang("ค่าตัวแปร::l::Variable"); ?></B><BR></CENTER>
<FORM METHOD=POST ACTION="save.php">
<INPUT TYPE="hidden" name="libsite" value="<?php  echo $libsite;?>">
	
<?php 

	/////////////////
$s=tmq("select * from libsite_vars order by name");
?><TABLE class=table_border width=780 align=center><?php 
while ($r=tmq_fetch_array($s)) {
	?><TR class=table_td>
	<TD><B><?php  echo getlang($r[name])?></B></TD>
	<TD>
<INPUT TYPE="text" name="VAR_<?php  echo $r[code] ?>" value="<?php echo getlibsitevars("$libsite",$r[code]);?>">
	</TD>
</TR>
<TR class=table_td>
	<TD colspan=2><?php  echo  getlang($r[descr])?></TD>
</TR>
<?php 
}

	///////////////
	?></td></tr>
	<TR>
		<TD colspan=3 align=center><INPUT TYPE="submit" value=" <?php  echo getlang("บันทึก::l::Save"); ?> "></TD>
	</TR>
	</FORM></TABLE><BR>
<CENTER><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER><?php 
foot();
?>