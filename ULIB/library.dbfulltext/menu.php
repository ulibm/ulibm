<?php 

    include ("../inc/config.inc.php");
	redir($dcrURL."library/mainadmin.php"); 
	die;// พ




include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

?><BR>
<TABLE width=400 align=center>
<TR>
	<TD><?php 
	html_librarymenu("dbfulltextmenu");
	?></TD>
</TR>
</TABLE>
<?php 

foot();
?>