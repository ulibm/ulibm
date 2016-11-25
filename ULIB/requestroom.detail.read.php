<?php 
;
include("./inc/config.inc.php");
head();
mn_web("requestroom");


?><BR><BR><table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>
<TR>
	<TD class=table_td align=center><?php 
	$old=tmq("select * from rqroom_eventinfo where id='$ID'  ",false);
  			$old=tmq_fetch_array($old);
			$old[text]=trim($old[text]);
			//printr($old);
				if (trim($old[text])!='') {
					pagesection($old[text]);
					// echo "<BR><b>$old[text]</b><br />";
				}
				if ($old[image]!='') {
					 echo "<img src='$dcrURL/_tmp/rqroomfile/$old[image]' align=absmiddle border=0 ><br />";
				}
	?></TD>
</TR>
<TR>
	<TD class=table_td><BLOCKQUOTE>
<?php 
if (trim($old[descr])!='') {
	 echo "<BR><b>".stripslashes($old[descr])."</b><br />";
}
if (trim($old[memid])!='') {
	 echo "<BR>".getlang("โดย::l::By")." ".get_member_name($old[memid])."<br />";
}
	?></BLOCKQUOTE></TD>
</TR>
</TABLE>
<CENTER><A HREF="javascript:self.close();"><?php  echo getlang("ปิดหน้าต่าง::l::Close window"); ?></A></CENTER>
<?php 

foot();
?>