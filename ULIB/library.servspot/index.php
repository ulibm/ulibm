<?php 
include("../inc/config.inc.php");
head();// พ
include("./_REQPERM.php");
mn_lib();

?><BR>
<TABLE width=400 align=center>
<TR>
	<TD><?php 
	html_librarymenu("servspotmenu");
	?></TD>
</TR>
</TABLE>
<?php 

foot();
?>