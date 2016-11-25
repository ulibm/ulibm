<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	pagesection("รายงานการรับชำระค่าปรับ แยกตามสาขาห้องสมุด");
	$usedatedt=form_pickdt_get("usedate");
?><TABLE width=700 align=center>
<FORM METHOD=POST ACTION="finelimit.php">
	<TR>
	<TD align=center> <?php  echo getlang("ค่าปรับของวันที่::l::Fine of date");?> <?php 
	form_pickdate("usedate",$usedatedt);
	?> <INPUT TYPE="submit" value=" OK " ></TD>
</TR>
</FORM>
</TABLE><?php 
//	local_dispfinebylib("$LIBSITE","ค่าปรับรายวันของ ".get_libsite_name($LIBSITE),$Fdat,$Fmon,$Fyea);
$s=tmq("select * from finedone where dat='$usedate_dat' and mon='$usedate_mon' and yea='$usedate_yea' order by dt ");

?><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<TD class=table_head width=5>-</TD>
	<TD class=table_head width=200><?php  echo getlang("ผู้ชำระ::l::Member")?></TD>
	<TD class=table_head width=200><?php  echo getlang("ผู้รับชำระ::l::Officer")?></TD>
	<TD class=table_head width=50><?php  echo getlang("บาท::l::฿")?></TD>
	<TD class=table_head width=50><?php  echo getlang("เครดิต::l::Credits")?></TD>
	<TD class=table_head width=50><?php  echo getlang("เวลา::l::Time")?></TD>
	<TD class=table_head width=5>-</TD>
</TR>
<?php 
$i=0;
$sum_cach=0;
$sum_credit=0;
while ($r=tmq_fetch_array($s)) {
$i++;?>
<TR>
	<TD class=table_head2 style="text-align: left"><?php  echo $i;?></TD>
	<TD class=table_head2 style="text-align: left"><B><?php  echo get_member_name($r[member])?></B></TD>
	<TD class=table_head2 style="text-align: left"><?php  echo get_library_name($r[lib])?></TD>
	<TD class=table_head2 style="text-align: right; border-width: 1;border-color: 777777"><?php  echo number_format($r[cach])?></TD>
	<TD class=table_head2 style="text-align: right; border-width: 1;border-color: 777777"><?php  echo number_format($r[credit])?></TD>
	<TD class=table_head2 align=center><?php  echo ymd_datestr($r[dt],"time")?></TD>
	<TD class=table_head2 align=center><A target=_blank HREF="../circulation/working.fine.fdd.php?id=<?php  echo $r[idid];?>&memberbarcode=<?php  echo $r[member];?>">View</A></TD>
</TR><?php 
$sql ="select * from fine where memberId='$r[member]' and idid='$r[idid]'";
$result = tmq($sql);
$cc=0;
$realsum=0;
while ($row = tmq_fetch_array($result)) {
	$cc++;
	$realsum=$realsum+$row[fine];

?>
<TR>
	<TD ></TD>
	<TD class=table_td colspan=4><FONT class=smaller><?php  echo $cc;?>.<?php  echo ($row[topic])?> (<?php  echo number_format($row[fine])?>฿)</FONT></TD>
</TR><?php 
}
?><TR>
	<TD colspan=1></TD>
	<TD class=table_td colspan=4 align=left><B><FONT class=smaller> ยอดจริง <?php  echo number_format($realsum)?>฿</FONT></B></TD>
</TR>
<?php 
$sum_cach=$sum_cach+$r[cach];
$sum_credit=$sum_credit+$r[credit];
	
}
?>
<TR>
	<TD colspan=3></TD>
	<TD class=table_head style="text-align: right"><?php  echo number_format($sum_cach)?></TD>
	<TD class=table_head style="text-align: right"><?php  echo number_format($sum_credit)?></TD>
</TR>
</TABLE><?php 
	 ?>
<BR>

<?php 
foot();
?>