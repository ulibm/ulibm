<?php 

function local_dispfinebylib($wh,$name,$Fdat,$Fmon,$Fyea) {
	global $thaimonstr;
	global $cfrm;
	$Fyea-=543;
	?>
	<TABLE width=780 align=center class=table_border>
	<TR>
		<TD class=table_head align=left><?php  echo getlang($name)?></TD>
	</TR>
	<TR>
		<TD class=table_td>
		<?php 
	$s="select * from finedone where 1";
	if ("$Fdat"!="") {
		$s="$s and dat='$Fdat' ";
	}
	if ("$Fmon"!="") {
		$s="$s and mon='$Fmon' ";
	}
		$s="$s and yea='$Fyea'  ";
	if ($wh!="LISTALLLIB") {
		$s="$s and  " . sql_gotallliblimit_bylibmember($wh,"lib");
	}
	$s="$s ";
	//echo $s;
	$s=tmq($s);	
	if (tmq_num_rows($s)==0) {
		?>
		<TABLE width=780 align=center class=table_border>
		<TR>
			<TD><?php  echo getlang("ไม่มีรายการชำระค่าปรับสำหรับ::l::No paid information for"); ?> <?php  echo getlang($name)?></TD>
		</TR>
		</TABLE>
		<?php 
	} else {
?><?php  echo getlang("มีค่าปรับจำนวน::l::Fine"); ?> <?php  echo tmq_num_rows($s); ?> <?php  echo getlang("รายการ รวมเป็นเงิน::l::records all fines is"); ?> <?php 
$fine=0;
$dat=Array();
while ($r=tmq_fetch_array($s))	 {
	$dat[$r[lib]]=$dat[$r[lib]]+$r[cach];
	$fine+=$r[cach];
}

echo number_format($fine);
?> <?php  echo getlang("บาท::l::Baht"); ?> <BR>
<B><?php  echo getlang("แบ่งตามผู้รับชำระดังนี้::l::Group by Librarian"); ?></B>
<TABLE class=table_border width=780>
<TR>
	<TD class=table_td width=70%><B><?php  echo getlang("ชื่อผู้รับชำระ::l::Librarian name"); ?></B></TD>
	<TD class=table_td><B><?php  echo getlang("จำนวนที่รับชำระ::l::Amount"); ?></B></TD>
</TR>
<?php 
foreach ($dat as $key => $value) {
?><TR>
	<TD class=table_td><?php  echo $key;
echo " (" . get_library_name($key).")";
?></TD>
	<TD class=table_td><?php  echo number_format($value);?></TD>
</TR>
<?php 
}
	?>
</TABLE><?php 
	
}
	?>
		</TD>
	</TR>
	</TABLE><?php 
	if ($wh!="LISTALLLIB")	{
	?><TABLE width=780 align=center>
		<TR>
			<TD><A class=a_btn HREF="finedaily-alllib.php?deletefinedone=<?php echo $wh?>" onclick="return confirm('<?php  echo $cfrm?>');"><?php echo getlang("ลบประวัติค่าปรับที่เกิน 1 เดือนของสาขาห้องสมุดนี้::l::Delete 1 month-old fine history");?></A> (<?php  echo get_libsite_name($wh);?>)</TD>
		</TR>
		</TABLE><?php 
	}	
	?><BR>
	<?php 
}
?>