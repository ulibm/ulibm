<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("upgrade_table");
			pagesection("Upgrade Table");

?><BR>
<TABLE align=center width=500 class=table_border>
<FORM METHOD=POST ACTION="step1.php">
<TR class=table_head>
	<TD colspan=2><?php  echo getlang("กรุณาระบุการเชื่อมต่อ::l::Please specific connection detail.");?></TD>
</TR>
<TR>
	<TD class=table_td>HOST</TD>
	<TD class=table_td><INPUT TYPE="text" NAME="ui_host" VALUE="<?php  echo $host;?>"></TD>
</TR>
<TR>
	<TD class=table_td>USER</TD>
	<TD class=table_td><INPUT TYPE="text" NAME="ui_user" VALUE="<?php  echo $user;?>"></TD>
</TR>
<TR>
	<TD class=table_td>PASSWORD</TD>
	<TD class=table_td><INPUT TYPE="password" NAME="ui_passwd" VALUE="<?php  echo $passwd;?>"></TD>
</TR>
<TR>
	<TD class=table_td>DATABASE</TD>
	<TD class=table_td><INPUT TYPE="text" NAME="ui_dbname" VALUE="<?php  echo $dbname;?>"></TD>
</TR>
<TR>
	<TD class=table_td>COLLATION</TD>
	<TD class=table_td><INPUT TYPE="text" NAME="ui_collation" VALUE="<?php  echo barcodeval_get("root_upgradetable_coll");?>"></TD>
</TR>

<TR>
	<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value="     Connect     "></TD>
</TR>

</FORM></TABLE><BR><FONT SIZE="" COLOR="red">
<CENTER><?php 
echo getlang("แนะนำให้ ทำการสำรองข้อมูลแบบ Full ก่อนลงมืออัพเกรด::l::Please Full-Backup your database befor do anythings");
?></CENTER></FONT>
<BR><?php 
foot();
?>