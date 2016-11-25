<?php  
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("remindersheet");
?><CENTER><?php  
echo getlang("กรุณาปรินท์เพจนี้ และเก็บไว้อย่างปลอดภัย::l::Please print this page and keep it securly");
?></CENTER>
<TABLE align=center width=780 cellpadding=2 border=1 bordercolor=black cellspacing=0>
<TR valign=top>
	<TD width=50%>
<B>URLs:<BR></B>
Homepage:<?php echo $dcrURL;?><BR>
Librarian:<?php echo $dcrURL;?>library/<BR>
Administrator:<?php echo $dcrURL;?>root/<BR><BR>
Gate:<?php echo $dcrURL;?>ms/<BR>
Installer:<?php echo $dcrURL;?>install/<BR>
<BR>
<B>Database Config:<BR></B>
Database name:<?php echo $dbname;?><BR>
Database User:<?php echo $user;?><BR>
Database host:<?php echo $host;?><BR>
Database Pwd:<?php echo substr($passwd,0,2);?>***** (Show 2 digit)<BR>
<BR>
<B>Server Config:<BR></B>
Main Path: <?php echo $dcrs;?><BR>
Member's Picture: <?php echo $dcrs;?>pic/<BR>
<BR>
<B>Misc Config:<BR></B>
Member's Picture size: <?php echo $memberspechtml;?><BR>
</TD>
<TD>
<B>All Administrator: </B><BR><?php  
$s=tmq("select * from useradmin");
while ($r=tmq_fetch_array($s)) {
	echo "&nbsp;&nbsp;&nbsp;<B>".$r[UserAdminName] . "</B><BR>
	&nbsp;&nbsp;&nbsp; Login: <B>" .$r[UserAdminID]."</B> Pwd: _________<BR>";
}
?><BR>
<B>All Librarians: </B><BR><?php  
$s=tmq("select * from library");
while ($r=tmq_fetch_array($s)) {
	echo "&nbsp;&nbsp;&nbsp;<B>".$r[UserAdminName] . "</B><BR>
	&nbsp;&nbsp;&nbsp; Login: <B>" .$r[UserAdminID]."</B> Pwd: _________<BR>";
}
?>
<BR>
<B>Login to server: </B><BR>
________________<BR>
________________<BR>
________________<BR>
________________<BR>
________________<BR>
<BR>
<B>Linux commands:</B><BR>
Shutdown: <B>shutdown -h now</B><BR>



<?php  
?>
</TD>
</TR>
</TABLE><?php  
foot();
?>