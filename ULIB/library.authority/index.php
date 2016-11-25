<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="authority";
mn_lib();

?><BR>
<TABLE width=400 align=center>
<TR>
	<TD><?php 
	html_librarymenu("authoritymenu");
	?></TD>
</TR>
</TABLE>
<?php 

foot();// พ
?>