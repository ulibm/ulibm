<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="hpsidebar";
mn_lib();

$localcatehead="yes";

pagesection("จัดการข้อมูล เนื้อหาแถบด้านข้างโฮมเพจ");
?><TABLE width=400 align=center>
<TR>
	<TD><?php 
html_librarymenu("hpsidebar_menu");
?></TD>
</TR>
</TABLE><?php 


foot();

?>