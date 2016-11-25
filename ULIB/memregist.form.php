<?php  
;
      include("inc/config.inc.php");
	   include("./index.inc.php");
	  head();
		mn_web('memregist');
		
		pagesection(getlang("รับสมัครสมาชิกออนไลน์::l::Online Registration"));
		if ($_memid!="") {
			die("_memid=$_memid");
		}
 ?><TABLE class=table_border align=center width=780 cellpadding=10>
 <TR>
	<TD class=table_head><?php  
	echo getlang("เงื่อนไขการรับสมัครสมาชิก::l::Agreement");
	?></TD>
 </TR>
 <TR>
	<TD><?php  
	echo barcodeval_get("memregist-agreement");
	?></TD>
 </TR>
  <TR>
	<TD class=table_head2><B><A HREF="memregist.form2.php" class=a_btn><?php  
	echo getlang("ยอมรับเงื่อนไข::l::I Agree");
	?></A></B></TD>
 </TR>
 </TABLE>

<?php  
foot();
?>