<?php 
include("../../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

?><BR>
<TABLE width=400 align=center>
<TR>
	<TD><?php 
	html_librarymenu("webmobilemenu");
	?></TD>
</TR>
</TABLE>
<center><a href="<?php  echo $dcrURL?>mobile" class="a_btn" target=_blank><?php  echo getlang("ไปยังหน้าเว็บสำหรับมือถือ::l::Go to mobile webpage");?></a></center>
<?php 

foot();
?>