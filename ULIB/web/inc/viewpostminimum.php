<?php 

function viewpostminimum($dat) {
	global $_tmid;
	global $backto;
	global $ismanager;
	global $tmiddata;
	global $_VAL_FILE_SAVEPATHurl;
?>	<TABLE class=table_border width=100% align=center>
<TR valign=top>
	<TD class=table_head width=20%>ชื่อหัวข้อ</TD>
	<TD class=table_td bgcolor=white><B><?php  echo $dat[topic]?></B></TD>
</TR>
<TR valign=top>
	<TD class=table_head width=20%>ตอบเมื่อ</TD>
	<TD class=table_td  style="background-color: white;" align=right><?php  echo ymd_datestr($dat[dt])?>&nbsp;</TD>
</TR>
<TR valign=top>
	<TD class=table_head width=20%><TABLE width=100% cellpadding=3 cellspacing=3>
	<TR>
		<TD align=center style="border-color: blue; border-style: solid; border-width: 1px; background-color: #F0FAFF"><?php 
	get_library_name($dat[tmid]);

?></TD>
	</TR>
	</TABLE></TD>
	<TD class=table_td style="background-color: white; padding-left: 4px;"><?php  echo ($dat[text])?></TD>
</TR>
<?php 
?>
</TABLE><TABLE align=center width=100% cellpadding=0 cellspacing=0 >
<TR>
	<TD height=5px bgcolor=#330099></TD>
</TR>
</TABLE>
<?php 
}

?>