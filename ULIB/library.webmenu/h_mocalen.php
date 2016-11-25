<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webpage-menu";
mn_lib();

$localcatehead="yes";

pagesection("จัดการข้อมูล เมนูเว็บไซต์");
?><TABLE width=400 align=center>
<TR>
	<TD><?php 
html_librarymenu("mocalen_menu");
?></TD>
</TR>
</TABLE><?php 


foot();

?>