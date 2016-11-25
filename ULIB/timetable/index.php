<?php 
    ;
	include("../inc/config.inc.php");
	head();
	$_REQPERM="rqroommenu";
	mn_lib();


?><BR>
<TABLE width=400 align=center>
<TR>
	<TD><?php 
html_librarymenu("rqroommenu");
?></TD>
</TR>
</TABLE>

<?php // พ
	foot();
?>