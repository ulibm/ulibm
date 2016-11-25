<?php 
	; 
		
    include ("../inc/config.inc.php");
	redir($dcrURL."library/mainadmin.php"); 
	die;





		head();
		include("_REQPERM.php");
    mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("จัดการหน้าเว็บ::l::Webpage Administrator"));
?>
<table border = 0 cellpadding = 0 width = 700 
align = center cellspacing=30>
	<tr>
	  <td valign = "top" width=50%>
<?php 
if (getval("_SETTING","form_at_hp")=="Wiki") {
	echo "<TABLE cellpadding=10 cellspacing=1 border=0 bgcolor=aaaaaa width=320>
	<TR>
		<TD bgcolor=f0f0f0>";
	html_librarymenu("webmenu-webpage");
	echo "</TD>
	</TR>
	</TABLE><BR>";
} elseif (getval("_SETTING","form_at_hp")=="webpage") {
	echo "<TABLE cellpadding=10 cellspacing=1 border=0 bgcolor=aaaaaa width=320>
	<TR>
		<TD bgcolor=f0f0f0 align=right>";
	html_librarymenu("webmenu-webpage");
	echo "<BR>";
	html_librarymenu("webmenu");
	echo "<A HREF='$dcrURL' target=_blank class=smaller2><BR>".getlang("ไปยังหน้าโฮมเพจ::l::Open Homepage")."</A>";
	echo "</TD>
	</TR>
	</TABLE><BR>";
} else {
?><BR><BR>
<TABLE width=100% align=center class=table_border>
	<TR>
		<TD class=table_head style="color: #7F7F7F"><?php  echo getlang("ข้อความ::l::Message");?></TD>
	</TR>
	<TR>
		<TD class=table_td><?php  echo getlang("ตัวเลือกของการจัดการโฮมเพจ ถูกระงับไว้ เนื่องจากไม่ได้ใช้หน้าหลักแบบเว็บเพจ::l::Homepage options was disabled because homepage type is not 'webpage'.");?></TD>
	</TR>
	</TABLE><BR><?php 
}

html_librarymenu("webmenu_webboard");
?><BR>
 <?php 
html_librarymenu("webmenu_bibrating");
?><BR>
 <?php 
html_librarymenu("webmenu_bibtag");
?>


</td>
 <td valign = "top" width=50%>

 <?php 
html_librarymenu("webmenu_web");
?><BR>
 <?php 
html_librarymenu("webmenu_marcincorrect");
?><BR>
 <?php 
html_librarymenu("webmenu-memregist");
?><BR>
 <?php 
html_librarymenu("webmenu_memfavbook");
?><BR>
 <?php 
html_librarymenu("bookcommentmenu");
 $del=tmq("select * from webpage_bookcomment where reportdelete>0");
 if (tmq_num_rows($del)>0) {
	 $del=tmq_num_rows($del);
	echo "<FONT class=smaller2 color=darkred>&nbsp;&nbsp;".getlang("มีรายการถูกแจ้งลบ $del รายการ::l::Report for delete $del")."</FONT>";
 }
?>



</td>
</tr>
</table>
<?php 
				foot();
?>