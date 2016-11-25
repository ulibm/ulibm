
<TABLE cellpadding=3 cellspacing=1 bgcolor=white align=center width=780 >

<TR>
	<TD align=left>
<TABLE cellpadding=3 cellspacing=1 bgcolor=black align=left width=100% class=table_border>
<TR>
	<TD class=table_head2>หมวดคำถามอื่น ๆ</TD>
</TR>

<TR>
	<TD><?php 
$s="select * from  webboard_boardcate where 1 ";
if ($ismanager!=true) {
	$s.= " and isshowtouser='yes' ";
}
	$s.=" order by ordr";
	$s=tmq($s);
	while ($r=tmq_fetch_array($s)) {
?><nobr>
๏  <A HREF="viewforum.php?ID=<?php  echo $r[id]?>"><?php  echo $r[name]?></A> /
</nobr><?php 
	}
	?></TD>
</TR>
</TABLE>

</TD>
	<TD></TD>
</TR>
</TABLE>