<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="libsiterule";
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
<CENTER><BR><B><?php  echo getlang("การอนุญาต::l::Permission"); ?></B><BR></CENTER>
<?php 
$s3=tmq("select * from library_site where code<>'$libsite' order by name ");
?><TABLE class=table_border width=780 align=center ><?php 
while ($r3=tmq_fetch_array($s3)) {
?><tr><td>
<B><?php 
echo $r3[name]
?></B>
</td></tr><tr><td>
<?php 

	/////////////////
$s=tmq("select * from libsite_modules order by name");
?><TABLE class=table_border width=780 align=center><?php 
while ($r=tmq_fetch_array($s)) {
	?><TR class=table_td>
	<TD><?php  echo getlang($r[name])?></TD>
	<TD>
	<?php 
	$tmp=tmq("select * from libsite_permission where libfrom='$libsite' and libto='$r3[code]' and code='$r[code]'  ");	
	if (tmq_num_rows($tmp)==0) {
		echo "<A HREF=\"permission.php?act=add&libsite=$libsite&libto=$r3[code]&code=$r[code]\"><IMG SRC=\"../image/red.jpg\" WIDTH=21 HEIGHT=21 BORDER=0 ></A>";
	} else {
		echo "<A HREF=\"permission.php?act=close&libsite=$libsite&libto=$r3[code]&code=$r[code]\"><IMG SRC=\"../image/green.jpg\" WIDTH=21 HEIGHT=21 BORDER=0 ></A>";
	}
	?>
	</TD>
</TR>
<?php 
}

	///////////////
	?></td></tr></TABLE><?php 
}
?>
</TABLE><BR>
<CENTER><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER><?php 
foot();
?>