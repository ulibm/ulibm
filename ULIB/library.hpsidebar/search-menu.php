<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="searchsidebar-menu";
mn_lib();

$localcatehead="yes";

pagesection("จัดการข้อมูล เนื้อหาแถบด้านข้างหน้าสืบค้น");
?><TABLE width=400 align=center>
<TR>
	<TD><?php 
html_librarymenu("hpsidebar_searchmenu");
?></TD>
</TR>
</TABLE><?php 
html_dialog("","ระบบนี้ใช้ในการจัดการหน้าเว็บแบบ webpage (แบบเดิม) เท่านั้น::l::This setting use in [webpage] (version 5.x) only");


foot();

?>