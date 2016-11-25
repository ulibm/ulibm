<?php  
	; 
		// พ
        include ("../inc/config.inc.php");
		head();
        mn_root("shellinfo");

			pagesection("Server information");

?><BR><TABLE width=500 align=center>
<TR>
	<TD><B>RESULTS</B></TD>
</TR>
<?php  
foreach ($command as $value) {
?><TR>
	<TD bgcolor=f7f7f7><B><?php  echo $value;?></B></TD>
</TR><TR>
	<TD><PRE><?php  
system("$value");	
?></PRE></TD>
</TR>
<?php  
		filelogs("shell executed",$value,"ShellEXEC");

}

?>
</TABLE><BR><CENTER><A HREF="index.php">Back</A></CENTER><BR><?php  
foot();
?>